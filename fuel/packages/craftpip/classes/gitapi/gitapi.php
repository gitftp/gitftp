<?php

namespace Craftpip;

class GitApi {
    public $auth;
    public $api;
    public $deploy;
    public $providers;

    public function __construct() {
        $this->auth = new \Craftpip\Auth();
        $this->deploy = new \Model_Deploy();

        $username = $this->auth->getAttr('github');
        if ($username) {
            $this->providers['github'] = new GitApi\Github($username);
            $this->providers['github']->authenticate($this->auth->getProviders('github', 'access_token'));
        }
        $username = $this->auth->getAttr('bitbucket');
        if ($username) {
            $this->providers['bitbucket'] = new GitApi\Bitbucket($username);
            $this->providers['bitbucket']->authenticate($this->auth->getProviders('bitbucket', 'access_token'));
        }
    }

    public function setDeployId($id) {

    }

    public function setRepoUrl() {

    }

    public function getRepositories() {
        $a = array();

    }

    public function loadApi($name) {
        switch ($name) {
            case 'github':
                if ($this->auth->getAttr('github') !== '')
                    $this->api = new \Craftpip\GitApi\Github($this->auth->getAttr('github'));
                break;
            case 'bitbucket':
                if ($this->auth->getAttr('bitbucket') !== '')
                    $this->api = new \Craftpip\GitApi\Bitbucket($this->auth->getAttr('bitbucket'));
                break;
            default:
                throw new Exception('Unknown provider name: ' . $name);
        }

        return $this->api;
    }
}