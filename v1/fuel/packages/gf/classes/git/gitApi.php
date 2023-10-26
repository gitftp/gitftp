<?php

namespace Gf\Git;

use Fuel\Core\Uri;
use Gf\Auth\OAuth;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\Providers\Bitbucket;
use Gf\Git\Providers\Github;
use Gf\Git\Providers\GitInterface;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class Git
 * This class wraps the api classes for github and bitbucket
 * methods here do not relate to github and bitbucket individually.
 * To get the individual api for github or bitbucket use the @see api method
 *
 * @package Gf\Git
 */
class GitApi {

    /**
     * @var GitApi
     */
    public static $instance;

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
     * @var AccessToken[]
     */
    public $tokens = [];

    /**
     * @param        $user_id
     * @param string $provider
     *
     * @return GitApi
     */
    public static function instance ($user_id, $provider = 'all') {
        if (!isset(static::$instance[$provider]) or null == static::$instance[$provider]) {
            $provider_const = ($provider == 'all') ? null : $provider;
            static::$instance[$provider] = new static($user_id, $provider_const);
        }

        return self::$instance[$provider];
    }

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

        if (!$providers)
            $providers = [];

        foreach ($providers as $k => $provider) {
            if ($provider['provider'] == OAuth::provider_github) {
                $this->providers[OAuth::provider_github] = new Github($provider['username']);
            } elseif ($provider['provider'] == OAuth::provider_bitbucket) {
                $this->providers[OAuth::provider_bitbucket] = new Bitbucket($provider['username']);
            }

            /**
             * @var AccessToken $token
             */
            $token = unserialize($provider['access_token']);
            $this->tokens[$provider['provider']] = $token;
            $expires = $token->getExpires();
            if (!empty($expires)) {
                if ($token->hasExpired()) {
                    $token = OAuth::instance($provider['provider'])->refreshToken($token, $provider['id']);
                    $this->tokens[$provider['provider']] = $token;
                }
            }

            /**
             * @var GitInterface
             */
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

        return Uri::base() . "hook/link/$user_id/$project_id/$key";
    }

    /**
     * creates url that is used for clone,
     * this clone url uses token for authentication
     *
     * @param $clone_url
     * @param $provider
     *
     * @return string
     * @throws \Gf\Exception\AppException
     */
    public function createAuthCloneUrl ($clone_url, $provider = null) {
        // here data is database record array.

        if (is_null($provider)) {
            if ($this->provider)
                $provider = $this->provider;
            else
                throw new AppException('Provider is required');
        }


        $token = $this->getToken($provider);
        if ($provider == OAuth::provider_bitbucket) {
            $username = "x-token-auth";
            $password = $token->getToken();
        } elseif ($provider == OAuth::provider_github) {
            $username = $this->providers[$provider]->username;
            $password = $token->getToken();
        } else {
            throw new AppException("Invalid provider, $provider given.");
        }

        $repo_url = parse_url($clone_url);
        $repo_url['user'] = $username;

        if ($password) {
            $repo_url['pass'] = $password;
        }
        $url = http_build_url($repo_url);

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
     * @return \Gf\Git\Providers\GitInterface
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

    /**
     * Get the token for the given providers
     *
     * @param null $provider -> if null, and initialized with one provider, will return that provider.
     *
     * @return AccessToken
     */
    public function getToken ($provider = null) {
        if (is_null($provider) and $this->provider) {
            return $this->tokens[$this->provider];
        } else {
            return $this->tokens[$provider];
        }
    }
}