<?php

namespace Gf\Deploy;

use Fuel\Core\Arr;
use Fuel\Core\Cache;
use Fuel\Core\Cli;
use Fuel\Core\Cookie;
use Fuel\Core\Fuel;
use Fuel\Core\Log;
use Gf\Deploy\Helper\DeployLife;
use Gf\Deploy\Helper\DeployLog;
use Gf\Deploy\Tasker\Deployer;
use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Git\GitLocal;
use Gf\Project;
use Gf\Record;
use Gf\Server;
use Gf\Utils;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;
use Symfony\Component\Process\Process;


/**
 * This class is responsible for deploying the files to the server.
 * Brings together all the resources to Deploy.
 * Loops over the deploy queue
 * Class Deploy
 *
 * @package Gf\Deploy
 */
class Deploy {

    /**
     * Instance for the class
     *
     * @var Deploy[]
     */
    public static $instances;

    /**
     * @var GitLocal
     */
    public $gitLocal;

    /**
     * The project details
     *
     * @var array[string]
     */
    public $project;

    /**
     * Id of the current project
     *
     * @var
     */
    public $project_id;

    /**
     * Full path of the location of the repository
     *
     * @var
     */
    public $repoPath;

    /**
     * Current fetched record, that the deploy is running on.
     *
     * @var
     */
    private $currentRecord;

    /**
     * Servers cache
     *
     * @var array
     */
    private $servers;

    /**
     * Current server that is being worked on.
     *
     * @var
     */
    private $currentServer = [];

    /**
     * Those files that are to be uploaded
     */
    const file_added = 'A';

    /**
     * Those files that are to be deleted
     */
    const file_deleted = 'D';

    /**
     * Those files that are modified
     */
    const file_modified = 'M';

    /**
     * Is this being run from CLI ?
     *
     * @var bool
     */
    private $isCli = false;

    /**
     * @var int
     */
    public $maxExecutionTime = 0;

    /**
     * Gitftp constructor.
     *
     * @param $project_id
     *
     * @throws \Gf\Exception\UserException
     */
    protected function __construct ($project_id) {
        $af = set_time_limit(0);
        $this->maxExecutionTime = ini_get('max_execution_time');

        /*
        if(!$af)
            throw new UserException('set_time_limit was not possible, please set time limit to 0');
        */

        $this->isCli = Fuel::$is_cli;
        $project = Project::get_one([
            'id' => $project_id,
        ]);
        if (!$project)
            throw new UserException('Project not found');

        $this->project = $project;
        $this->project_id = $project_id;
        $repoPath = $project['path'];
        $base = DOCROOT;
        $this->repoPath = Utils::systemDS($base . $repoPath);
    }

    /**
     * @param $project_id
     *
     * @return \Gf\Deploy\Deploy
     */
    public static function instance ($project_id) {
        if (!isset(static::$instances[$project_id]) or null == static::$instances[$project_id]) {
            static::$instances[$project_id] = new static($project_id);
        }

        return self::$instances[$project_id];
    }

    /**
     * Process queue where the conditions are met.
     * this is when multiple servers will work together.
     * not sorted out yet.
     * Idea:
     * If there are multiple servers defined,
     * those servers will run deploy individually.
     * This is not possible because the script will require the git directory to be checked out at different branches.
     * to use the files for upload.
     *
     * @param      $server_id
     * @param bool $loop -> loop over the where clause until the results end
     *
     * @return string
     */
    public function processServerQueue ($server_id, $loop = false) {
        $record = Record::get_one([
            'server_id' => $server_id,
            'status'    => Record::status_new,
        ], null, 1, 0, 'id', 'asc', false);

        if (!$record)
            return 'The queue is over';

        $this->currentRecord = $record;
        $this->processRecord();

        if ($loop)
            return $this->processServerQueue($server_id, $loop);

        return 'The queue is over without looping';
    }

    /**
     * Process queue where the conditions are met.
     * one record will be processed once for a project.
     *
     * @param bool $loop -> loop over the where clause until the results end
     *
     * @return string
     * @internal param $server_id
     */
    public function processProjectQueue ($loop = false) {
        sleep(1);

        $record = Record::get_one([
            'project_id' => $this->project_id,
            'status'     => Record::status_new,
        ], null, 1, 0, 'id', 'asc', false);

        if (!$record) {
            Log::info('The queue is over');

            return 'The queue is over';
        }


        $this->currentRecord = $record;
        $this->processRecord();

        if ($loop)
            return $this->processProjectQueue($loop);

        Log::info('The queue is over without looping');

        return 'The queue is over without looping';
    }


    /**
     * Process a single record
     * This should never throw a exception
     * Please do all the fail checks
     *
     * @param null $record_id
     * @param null $record
     *
     * @return bool
     */
    public function processRecord ($record_id = null, $record = null) {
        try {
            if (is_null($record_id)) {
                if ($this->currentRecord) {
                    $record_id = $this->currentRecord['id'];
                } else {
                    throw new UserException('Record id is required');
                }
            }

            if (is_null($record)) {
                $record = $this->currentRecord;
                if (is_null($record)) {
                    $record = Record::get_one([
                        'id' => $record_id,
                    ]);
                }
            }

            DeployLife::lock($this->project_id);

            if ($record['type'] == Record::type_clone) {
                $this->cloneRepo($record);
            } elseif ($record['type'] == Record::type_fresh_upload) {
                $this->freshUpload($record);
            } elseif ($record['type'] == Record::type_update) {
                $this->revisionDeploy($record);
            } else {
                throw new UserException('Record type is invalid');
            }

            DeployLife::lock($this->project_id);

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), __METHOD__);

            return false;
        }
    }


    /**
     * Deploy type: clone
     * Clone the project
     *
     * @param $record
     *
     * @return bool|\GitWrapper\GitWorkingCopy
     * @throws \Exception
     */
    public function cloneRepo ($record) {
        $record_id = $record['id'];
        try {
            $this->gitLocal = GitLocal::instance($this->repoPath);
            list($listener, $file) = DeployLog::createListener();
            $this->gitLocal->setListener($listener);

            $p = new Process('git --version');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ git --version \n$o");

            $p = new Process('php -v');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ php -v \n$o");
            DeployLog::log("\$ php max_timeout " . $this->maxExecutionTime);

            Record::update([
                'id' => $record_id,
            ], [
                'status'   => Record::status_processing,
                'log_file' => $file,
            ]);

            DeployLog::log('Starting..', __FUNCTION__);

            if (!$this->gitLocal->git->isCloned()) {
                Project::update([
                    'id' => $this->project_id,
                ], [
                    'clone_state' => Project::clone_state_cloning,
                ]);

                DeployLog::log('Cloning project', __FUNCTION__);
                $this->cloneMe();
                DeployLife::lock($this->project_id);
            }

            Project::update([
                'id' => $this->project_id,
            ], [
                'clone_state' => Project::clone_state_cloned,
            ]);
            DeployLog::log('DONE. project cloned', __FUNCTION__);

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_success,
            ]);

            return true;
        } catch (\Exception $e) {
            DeployLog::log($e->getMessage(), '>ERR');

            Project::update([
                'id' => $this->project_id,
            ], [
                'clone_state' => Project::clone_state_not_cloned,
            ]);
            Record::update([
                'id' => $record_id,
            ], [
                'status'        => Record::status_failed,
                'failed_reason' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function freshUpload ($record) {
        $record_id = $record['id'];

        try {
            $this->gitLocal = GitLocal::instance($this->repoPath);
            list($listener, $file) = DeployLog::createListener();
            $this->gitLocal->setListener($listener);

            $p = new Process('git --version');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ git --version \n$o");

            $p = new Process('php -v');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ php -v \n$o");
            DeployLog::log("\$ php max_timeout " . $this->maxExecutionTime);

            $this->currentServer = $this->getCacheServerData($record['server_id']);

            Record::update([
                'id' => $record_id,
            ], [
                'status'   => Record::status_processing,
                'log_file' => $file,
            ]);

            if (!$this->gitLocal->git->isCloned()) {
                DeployLog::log('Cloning project..', __FUNCTION__);
                $this->cloneMe();
            } else {
                DeployLog::log('Pulling changes', __FUNCTION__);
                $this->pull();
            }
            DeployLife::lock($this->project_id);

            $this->gitLocal->git->checkout($this->currentServer['branch']);
            $this->gitLocal->git->checkout($this->currentRecord['target_revision']);
            DeployLog::log("Checkout {$this->currentRecord['target_revision']} - {$this->currentServer['branch']}", __FUNCTION__);
            $allFiles = $this->getAllFilesForRevision($this->currentRecord['target_revision']);
            $totalFiles = count($allFiles);
            DeployLog::log("$totalFiles changed files", __FUNCTION__);

            Record::update([
                'id' => $record_id,
            ], [
                'total_files' => $totalFiles,
                'added_files' => $totalFiles,
            ]);

            DeployLog::log("Starting deploying..", __FUNCTION__);

            $deployer = Deployer::instance(Deployer::method_regular, $this->gitLocal, $this->currentServer);
            $deployer
                ->clearFiles()
                ->setRecord($this->currentRecord)
                ->setServer($this->currentServer)
                ->addFiles($allFiles)
                ->start();

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_success,
            ]);

            Server::update([
                'id' => $record['server_id'],
            ], [
                'revision' => $record['target_revision'],
            ]);

            DeployLog::log('DONE.', __FUNCTION__);
            return true;
        } catch (\Exception $e) {
            DeployLog::log($e->getMessage(), ">ERR");

            Record::update([
                'id' => $record_id,
            ], [
                'status'        => Record::status_failed,
                'failed_reason' => $e->getMessage(),
            ]);
            echo $e->getFile();
            throw $e;
        }
    }

    public function revisionDeploy ($record) {
        $record_id = $record['id'];

        try {
            $this->gitLocal = GitLocal::instance($this->repoPath);
            list($listener, $file) = DeployLog::createListener();
            $this->gitLocal->setListener($listener);
            $this->currentServer = $this->getCacheServerData($record['server_id']);

            $p = new Process('git --version');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ git --version \n$o");

            $p = new Process('php -v');
            $p->run();
            $o = $p->getOutput();
            DeployLog::log("\$ php -v \n$o");
            DeployLog::log("\$ php max_timeout " . $this->maxExecutionTime);

            DeployLog::log('Starting..', __FUNCTION__);

            Record::update([
                'id' => $record_id,
            ], [
                'status'   => Record::status_processing,
                'log_file' => $file,
            ]);

            if (!$this->gitLocal->git->isCloned()) {
                DeployLog::log('Cloning project', __FUNCTION__);
                $this->cloneMe();
            } else {
                DeployLog::log('Pulling changes', __FUNCTION__);
                $this->pull();
            }

            $this->gitLocal->git->checkout($this->currentServer['branch']);
            $this->gitLocal->git->checkout($this->currentRecord['target_revision']);

            DeployLog::log("Checkout {$this->currentRecord['target_revision']} - {$this->currentServer['branch']}", __FUNCTION__);

            /*
             * set the latest revision on the server.
             */
            $currentRevisionOnServer = Server::get_one([
                'id' => $this->currentServer['id'],
            ], [
                'revision',
            ]);

            list($files, $edited, $added, $deleted) = $this->gitLocal->diff($currentRevisionOnServer['revision'], $record['target_revision']);
            $totalFiles = count($files);
            DeployLog::log("$totalFiles changed files", __FUNCTION__);

            Record::update([
                'id' => $record_id,
            ], [
                'revision'      => $currentRevisionOnServer['revision'],
                'total_files'   => $totalFiles,
                'edited_files'  => $edited,
                'added_files'   => $added,
                'deleted_files' => $deleted,
            ]);

            DeployLog::log("Starting deploying..", __FUNCTION__);

            $deployer = Deployer::instance(Deployer::method_regular, $this->gitLocal, $this->currentServer);
            $deployer
                ->clearFiles()
                ->setRecord($this->currentRecord)
                ->setServer($this->currentServer)
                ->addFiles($files)
                ->start();

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_success,
            ]);

            Server::update([
                'id' => $record['server_id'],
            ], [
                'revision' => $record['target_revision'],
            ]);

            DeployLog::log('DONE.', __FUNCTION__);

            return true;
        } catch (\Exception $e) {
            DeployLog::log("{$e->getCode()}: {$e->getMessage()} @ {$e->getFile()}:{$e->getLine()}", '>ERR');

            Record::update([
                'id' => $record_id,
            ], [
                'status'        => Record::status_failed,
                'failed_reason' => $e->getMessage(),
            ]);

            throw $e;
        }
    }


    /**
     * Gets and caches the server data for the current server.
     *
     * @param $server_id
     *
     * @return mixed
     */
    private function getCacheServerData ($server_id) {
        if (!isset($this->servers[$server_id])) {
            $server = Server::get_one([
                'id' => $server_id,
            ]);
            $this->servers[$server_id] = $server;
        }

        return $this->servers[$server_id];
    }

    /**
     * Clones the repository for the current project.
     *
     * @return bool
     */
    private function cloneMe () {
        if (!$this->gitLocal->git->isCloned()) {
            $provider = $this->project['provider'];
            $gitApi = GitApi::instance($this->project['owner_id'], $provider);
            $clone_url = $gitApi->createAuthCloneUrl($this->project['clone_uri'], $provider);
            DeployLog::log($clone_url, __FUNCTION__);
            $this->gitLocal->cloneMe($clone_url);
        }

        return true;
    }

    private function pull () {
        return $this->gitLocal->pull($this->project['owner_id'], $this->project['provider'], $this->project['clone_uri']);
    }

    /**
     * Gets all the files that were on the revision
     * returns the files type array
     * [
     *  'file' => 'full/path/to/file.',
     *  'type' => action type
     * ]
     *
     * @param $revision
     *
     * @return array
     */
    private function getAllFilesForRevision ($revision) {
        $this->gitLocal->git->clearOutput();
        $this->gitLocal->git->run([
            'ls-tree',
            '--full-tree',
            '-r',
            $revision,
        ]);
        $files = $this->gitLocal->git->getOutput();
        $files = explode("\n", $files);
        $filesParsed = [];
        foreach ($files as $file) {
            if (!$file or empty($file))
                continue;
            $f = explode("\t", $file);
            $filesParsed[] = [
                'f' => $f[1], // full path
                'a' => self::file_added,
            ];
        }

        return $filesParsed;
    }
}
