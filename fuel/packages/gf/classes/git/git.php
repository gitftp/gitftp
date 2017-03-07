<?php

namespace Gf\Git;

use Gf\Auth\Auth;
use Gf\Auth\OAuth;
use League\OAuth2\Client\Token\AccessToken;

class Git {

    /**
     * @var GitInterface
     */
    public $instance;

    /**
     * List of provider instances
     *
     * @var GitInterface[]
     */
    public $providers = [];

    public function __construct ($user_id = null) {
        $providers = OAuth::getProviders([
            'parent_id' => $user_id,
        ]);

        foreach ($providers as $provider) {
            if ($provider['provider'] == OAuth::provider_github) {
                $this->providers[OAuth::provider_github] = new Github($provider['username']);
            } elseif ($provider['provider'] == OAuth::provider_bitbucket) {
                $this->providers[OAuth::provider_bitbucket] = new Bitbucket($provider['username']);
            }

            /**
             * @var AccessToken $token
             */
            $token = unserialize($provider['access_token']);
            $expires = $token->getExpires();
            if (!empty($expires)) {
                if ($token->hasExpired()) {
                    $token = OAuth::instance($provider['provider'])->refreshToken($token, $provider['id']);
                }
            }
            $this->providers[$provider['provider']]->authenticate($token);
        }
    }

    public function buildHookUrl ($deploy_id, $key, $user_id = null) {
        if (is_null($user_id))
            $user_id = $this->auth->user_id;

        return dash_url . "hook/i/$user_id/$deploy_id/$key";
    }

    public function setDeployId ($id) {

    }

    public function parseRepositoryCloneUrl ($data, $provider) {
        // here data is database record array.
        $url = $data['repository'];
        if ($data['git_name'] !== '') {
            if ($provider == 'github') {
                if ($username = $this->auth->getToken('github')) {
                    $username = $username->getToken();
                } else {
                    throw new Exception('Github account is not accessible');
                }
            }
            if ($provider == 'bitbucket') {
                // check for expired token.
                $token = $this->auth->getToken('bitbucket');
                if ($token) {
                    if ($token->hasExpired()) {
                        $token = $this->auth->refreshToken($provider['provider']);
                    }
                    $username = 'x - token - auth';
                    $password = $token->getToken();
                } else {
                    throw new Exception('Bitbucket account is not accessible');
                }
            }
        } else {
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

    public function getRepositories () {
        $r = [];
        foreach ($this->providers as $provider) {
            $repositories = $provider->getRepositories();
            $r = array_merge($r, $repositories);
        }

        return $r;
    }

    public function loadApi ($name) {
        try {
            $api = $this->api = $this->providers[strtolower($name)];
        } catch (\Exception $e) {
            throw new Exception('Provider not found: ' . $name);
        }

        return $api;
    }
}