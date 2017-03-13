<?php

namespace Gf\Deploy;

use Gf\Deploy\Tasker\ConnectionWorker;
use Gf\Deploy\Tasker\FileTask;
use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Project;
use Gf\Record;
use Gf\Server;
use Gf\Utils;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;

class Deploy {

    /**
     * Instance for the class
     *
     * @var Deploy[]
     */
    public static $instances;

    /**
     * Instance for the Git wrapper
     *
     * @var GitWorkingCopy
     */
    public $git;

    /**
     * @var GitWrapper
     */
    public $gitWrapper;

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

        $wrapper = new GitWrapper();
        $this->git = $wrapper->workingCopy($this->repoPath);
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
                $status = $this->cloneRepo($record);
            } elseif ($record['type'] == Record::type_re_upload) {
                $status = $this->freshUpload($record);
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

            if (!$this->git->isCloned()) {
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

//            Record::update([
//                'id' => $record_id,
//            ], [
//                'status' => Record::status_processing,
//            ]);

            if (!$this->git->isCloned())
                $this->clone();

            $this->git->checkout($this->currentServer['branch']);
            $this->git->checkout($this->currentRecord['target_revision']);
            $allFiles = $this->getAllFilesForRevision($this->currentRecord['target_revision']);
            $totalFiles = count($allFiles);

            $connection = Connection::instance($this->currentServer);

            $workPool = new \Pool(2, ConnectionWorker::class, [
                $this->currentServer,
                $this->currentRecord,
                $this->git,
                $connection->connection(),
            ]);

            foreach ($allFiles as $fileAction) {
                $workPool->submit(new FileTask($fileAction));
            }

            $workPool->shutdown();

            $workPool->collect(function ($checkingTask) {
                var_dump($checkingTask);
            });

            $filesToUpload = [];
            $filesToDelete = [];


            /*
             *
             *
             * git ls-tree --full-tree -r 9e51ab390806c36467af9ae464846c6d0e984327
            100644 blob e69de29bb2d1d6434b8b29ae775ad8c2e48c5391    file - Copy (2).txt
            100644 blob e69de29bb2d1d6434b8b29ae775ad8c2e48c5391    file - Copy - Copy.txt
            100644 blob e69de29bb2d1d6434b8b29ae775ad8c2e48c5391    file - Copy.txt

             *
             *
             *
             *git show 4d972d09c517f0524c0fe32eb5c7454ca0cafc96:file.txt
             *
             *
             *
             * */
//            $this->git->diff('');
//            $this->git->show('');


//            $this->git->run([
//                'submodule',
//                'foreach',
//                'git',
//                'submodules',
//                'status',
//            ]);


            // do deploy here.

            Record::update([
                'id' => $record_id,
            ], [
                'status' => Record::status_success,
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
        if (!$this->git->isCloned()) {
            $provider = $this->project['provider'];
            $gitApi = new GitApi($this->project['owner_id'], $provider);
            $clone_url = $gitApi->createAuthCloneUrl($this->project['clone_uri'], $provider);
            $this->git = $this->git->cloneRepository($clone_url);
            $this->git->getOutput();
            $this->git->setCloned(true);
        }

        return true;
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
        $this->git->clearOutput();
        $this->git->run([
            'ls-tree',
            '--full-tree',
            '-r',
            $revision,
        ]);
        $files = $this->git->getOutput();
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
}