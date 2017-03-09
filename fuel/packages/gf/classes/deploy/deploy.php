<?php

namespace Gf\Deploy;

use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Project;
use Gf\Utils;
use GitWrapper\Event\GitLoggerListener;
use GitWrapper\Event\GitOutputStreamListener;
use GitWrapper\GitWrapper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Deploy {

    /**
     * Instance for the class
     *
     * @var Deploy
     */
    public static $instance;

    /**
     * Instance for the Git wrapper
     *
     * @var Git
     */
    public $git;

    /**
     * Gitftp constructor.
     */
    protected function __construct () {
//        $this->git = new Git();
    }

    public static function instance () {
        if (null == static::$instance) {
            static::$instance = new static();
        }

        return self::$instance;
    }

    public function clone($project_id) {
        $project = Project::get_one([
            'id' => $project_id,
        ]);

        if (!$project)
            throw new UserException('Project not found');

        if ($project['clone_state'] != Project::clone_state_not_cloned)
            throw new UserException('This project has been cloned or is in the process of cloning');

        $provider = $project['provider'];
        $gitApi = new GitApi($project['owner_id'], $provider);
        $clone_url = $gitApi->createAuthCloneUrl($project['clone_uri'], $provider);
        $repoPath = $project['path'];
        $base = DOCROOT;
        $path = Utils::systemDS($base . $repoPath);


        $log = new Logger('git');
        $log->pushHandler(new StreamHandler('git.log', Logger::DEBUG));
        $listener = new GitOutputStreamListener($log);
        $wrapper = new GitWrapper();
        $wrapper->addOutputListener($listener);

        $git = $wrapper->cloneRepository($clone_url, $path);
        $op = $git->getOutput();
        $ic = $git->isCloned();

//        $git = $wrapper->workingCopy($path);
//        $branches = $git->isCloned();
//        $op = $git->cloneRepository($clone_url);
//        $op2 = $git->getOutput();
//        $isClonedNow = $git->isCloned();

//        $a = $this->git->clone($clone_url, $path);
//
//        if (!$a)
//            throw new UserException('Failed to clone the repository');
    }

    public function processQueue () {

    }

}