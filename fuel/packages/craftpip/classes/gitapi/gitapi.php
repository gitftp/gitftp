<?php

namespace Craftpip;

class GitApi {
    private $user;
    public $api;
    public $providers = array();

    public function __construct() {
        $this->user = new Auth();

        $username = $this->user->getAttr('github');
        if ($username)
            $this->providers['github'] = new GitApi\Github($username);


        $username = $this->user->getAttr('bitbucket');
        if ($username)
            $this->providers['bitbucket'] = new GitApi\Bitbucket($username);

    }

    public function getAllRepositories() {
        $response = array();
        foreach ($this->providers as $provider) {
            foreach ($provider->getRepositories() as $p) {
                $response[] = $p;
            };
        }

        return $response;
    }

    public function getApi($apiName) {
        if (isset($this->provider[$apiName])) {
            return $this->provider[$apiName];
        } else {
            return FALSE;
        }
    }
}