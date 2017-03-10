<?php

namespace Gf\Deploy;

use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Project;
use Gf\Record;
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

        $this->processRecord($record['id'], $record);

        if ($loop)
            return $this->processServerQueue($server_id, $loop);

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
    public function processRecord ($record_id, $record = null) {
        try {
            if (is_null($record))
                $record = Record::get_one([
                    'id' => $record_id,
                ]);

            if ($record['type'] == Record::type_clone) {
                $status = $this->clone($record);
            } elseif ($record['type'] == Record::type_re_upload) {

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
    public function clone($record) {
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

                $provider = $this->project['provider'];
                $gitApi = new GitApi($this->project['owner_id'], $provider);
                $clone_url = $gitApi->createAuthCloneUrl($this->project['clone_uri'], $provider);
                $this->git = $this->git->cloneRepository($clone_url);
                $this->git->getOutput();
                $this->git->setCloned(true);
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
}