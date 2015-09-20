<?php

namespace Craftpip;

class GitApi {
    public $auth;
    public $api;
    public $deploy;
    public $providers;

    public function __construct($user_id = NULL) {
        $this->auth = new \Craftpip\OAuth\OAuth($user_id);
        $this->deploy = new \Model_Deploy();

        if (!is_null($user_id))
            $this->deploy->user_id = $user_id;
        $this->providers = array();
        $providers = $this->auth->getProviders();

        foreach($providers as $provider){
            $class = "\\Craftpip\\GitApi\\".ucfirst(strtolower($provider['provider']));
            $this->providers[strtolower($provider['provider'])] = new $class($provider['username']);
            $token = unserialize($provider['access_token']);
            $expires = $token->getexpires();
            if(!empty($expires)){
                if($token->hasExpired()){
                    $token = $this->auth->refreshToken($provider['provider']);
                }
            }
            $this->providers[strtolower($provider['provider'])]->authenticate($token);
        }
    }

    public function buildHookUrl($deploy_id, $key, $user_id = NULL) {
        if (is_null($user_id))
            $user_id = $this->auth->user_id;

        return dash_url . "hook/i/$user_id/$deploy_id/$key";
    }

    public function setDeployId($id) {

    }

    public function parseRepositoryCloneUrl($data, $provider) {
        // here data is database record array.
        $url = $data['repository'];
        if($data['git_name'] !== ''){
            if($provider == 'github'){
                $username = $this->auth->getToken('github')->getToken();
            }
            if($provider == 'bitbucket') {
                // check for expired token.
                $token = $this->auth->getToken('bitbucket');
                if($token->hasExpired()){
                    $token = $this->auth->refreshToken($provider['provider']);
                }
                $username = 'x-token-auth';
                $password = $token->getToken();
            }
        }else{
            // manual
            $username = $data['username'];
            $password = $data['password'];
        }

        if (!empty($username)) {
            $repo_url = parse_url($url);
            $repo_url['user'] = $username;

            if (!empty($password)) {
                $repo_url['pass'] = $password;
            }
            $url = http_build_url($repo_url);
        }
        return $url;
    }
    public function getRepositories() {
        $r = array();
        foreach ($this->providers as $provider) {
            $repos = $provider->getRepositories();
            $r = array_merge($r, $repos);
        }

        return $r;
    }

    public function loadApi($name) {
        try {
            $api = $this->api = $this->providers[strtolower($name)];
        } catch (\Exception $e) {
            throw new Exception('Provider not found: ' . $name);
        }
        return $api;
    }
}