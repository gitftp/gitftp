<?php

namespace Gf\Deploy;

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
     * Instance for the Git wrapper
     *
     * @var GitWorkingCopy
     */
//    public $git;

    /**
     * @var GitWrapper
     */
//    public $gitWrapper;

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
    const file_action_upload = 1;

    /**
     * Those files that are to be deleted
     */
    const file_action_delete = 2;

    /**
     * Logs
     *
     * @var string
     */
    private $messages = '';

    /**
     * Gitftp constructor.
     *
     * @param $project_id
     *
     * @throws \Gf\Exception\UserException
     */
    protected function __construct ($project_id) {
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

//        $wrapper = new GitWrapper();
//        $this->git = $wrapper->workingCopy($this->repoPath);
        $this->gitLocal = GitLocal::instance($this->repoPath);
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
        $record = Record::get_one([
            'project_id' => $this->project_id,
            'status'     => Record::status_new,
        ], null, 1, 0, 'id', 'asc', false);

        if (!$record)
            return 'The queue is over';

        $this->currentRecord = $record;
        $this->processRecord();

        if ($loop)
            return $this->processProjectQueue($loop);

        return 'The queue is over without looping';
    }


    /**
     * Process a single record.
     *
     * @param      $record_id
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

            if ($record['type'] == Record::type_clone) {
                $this->cloneRepo($record);
            } elseif ($record['type'] == Record::type_fresh_upload) {
                $this->freshUpload($record);
            } elseif ($record['type'] == Record::type_update) {

            } else {
                throw new UserException('Record type is invalid');
            }

            return true;
        } catch (\Exception $e) {
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
        try {
            $record_id = $record['id'];

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_processing,
            ]);

            if (!$this->gitLocal->git->isCloned()) {
                Project::update([
                    'id' => $this->project_id,
                ], [
                    'clone_state' => Project::clone_state_cloning,
                ]);

                $this->clone();
            }

            Project::update([
                'id' => $this->project_id,
            ], [
                'clone_state' => Project::clone_state_cloned,
            ]);
            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_success,
            ]);

            return true;
        } catch (\Exception $e) {
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
        try {
            $record_id = $record['id'];
            $this->currentServer = $this->getCacheServerData($record['server_id']);

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_processing,
            ]);

            if (!$this->gitLocal->git->isCloned())
                $this->clone();
            else
                $this->pull();


            $this->gitLocal->git->checkout($this->currentServer['branch']);
            $this->gitLocal->git->checkout($this->currentRecord['target_revision']);
            $allFiles = $this->getAllFilesForRevision($this->currentRecord['target_revision']);
            $totalFiles = count($allFiles);

            Record::update([
                'id' => $record_id,
            ], [
                'total_files' => $totalFiles,
            ]);

            $connection = Connection::instance($this->currentServer);

            $deployer = Deployer::instance(Deployer::method_pthreads, $this->gitLocal);
            $deployer
                ->clearFiles()
                ->setRecord($this->currentRecord)
                ->setServer($this->currentServer)
                ->setConnection($connection->connection())
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

            return true;
        } catch (\Exception $e) {
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
    private function clone () {
        if (!$this->gitLocal->git->isCloned()) {
            $provider = $this->project['provider'];
            $gitApi = GitApi::instance($this->project['owner_id'], $provider);
            $clone_url = $gitApi->createAuthCloneUrl($this->project['clone_uri'], $provider);
            $this->gitLocal->clone($clone_url);
        }

        return true;
    }

    private function pull () {
        return $this->gitLocal->pull($this->project['id'], $this->project['provider'], $this->project['clone_uri']);
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
                'file'   => $f[1], // full path
                'action' => self::file_action_upload,
            ];
        }

        return $filesParsed;
    }

    /**
     * Log details about the deployment
     *
     * @param $messages
     */
    private function log ($messages) {
        $this->messages .= $messages . "\n";
    }

    /**
     * @return string
     */
    public function getMessages () {
        return $this->messages;
    }
}