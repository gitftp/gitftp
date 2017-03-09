<?php

namespace Gf\Deploy;

use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Project;
use Gf\Utils;
use PHPGit\Git;

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
    public static $git;

    /**
     * Gitftp constructor.
     */
    protected function __construct () {
        self::$git = new Git();
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

//        $this->git->clone()
    }


}