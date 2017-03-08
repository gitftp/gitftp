<?php

namespace Gf\Git;

use Fuel\Core\Uri;
use Gf\Auth\Auth;
use Gf\Auth\OAuth;
use Gf\Exception\UserException;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class Git
 * This class wraps the api classes for github and bitbucket
 * methods here do not relate to github and bitbucket individually.
 * To get the individual api for github or bitbucket use the @see api method
 *
 * @package Gf\Git
 */
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

    /**
     * If the Class was initialized with only one provider.
     * it will be stored here
     */
    public $provider = false;

    /**
     * @var
     */
    public $user_id;


    /**
     * Git constructor.
     *
     * @param null $user_id
     * @param null $provider -> initialize only this provider.
     *                       Saves resources.
     */
    public function __construct ($user_id, $provider = null) {
        $this->user_id = $user_id;
        $where = [
            'parent_id' => $user_id,
        ];
        if (!is_null($provider)) {
            $this->provider = $provider;
            $where['provider'] = $provider;
        }

        $providers = OAuth::getProviders($where);

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
            $this->providers[$provider['provider']]->authenticate($token->getToken());
        }
    }

    /**
     * @param      $project_id
     * @param      $key
     * @param null $user_id
     *
     * @return string
     */
    public function createHookUrl ($project_id, $key, $user_id = null) {
        if (is_null($user_id))
            $user_id = $this->user_id;

        return Uri::base() . "hook/i/$user_id/$project_id/$key";
    }

    /**
     * creates url that is used for clone,
     * this clone url uses token for authentication
     *
     * @param $data
     * @param $provider
     *
     * @return string
     */
    public function createCloneUrl ($data, $provider) {
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

    /**
     * Get combined repositories of all providers available
     *
     * @return array
     */
    public function getCombinedRepositories () {
        $r = [];
        foreach ($this->providers as $provider) {
            $repositories = $provider->getRepositories();
            $r = array_merge($r, $repositories);
        }

        return $r;
    }

    /**
     * @param $provider -> if this is null and the class has only one provider with it
     *                  the method will return the first one
     *
     * @return \Gf\Git\GitInterface
     * @throws \Gf\Exception\UserException
     */
    public function api ($provider = null) {
        try {
            if (is_null($provider) and count($this->providers) == 1) {
                return $this->providers[$this->provider];
            } else {
                return $this->providers[$provider];
            }
        } catch (\Exception $e) {
            throw new UserException("The provider $provider is not initialized");
        }
    }
}