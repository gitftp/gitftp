<?php

namespace Gf\Auth;

use Fuel\Core\DB;
use Fuel\Core\Uri;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Utils;
use League\OAuth2\Client\Provider\Github;
use Gf\Exception\AppException;
use Gf\Settings;
use \GuzzleHttp\Client as Client;
use League\OAuth2\Client\Token\AccessToken;
use Stevenmaguire\OAuth2\Client\Provider\Bitbucket;

/**
 * Class OAuth
 * Wrapper class to validate OAUTH logins.
 *
 * @property  instance
 * @package Gf\Auth
 */
class OAuth {
    /**
     * stores the applications id and secret keys.
     *
     * @var array
     */
    private $oauthApplicationConfig = [];
    /**
     * Contains options like scope
     *
     * @var array
     */
    private $oauthApplicationOptions = [];
    /**
     * Callback for the provider
     *
     * @var string
     */
    private $callbackUrl;


    // start response data.

    /**
     * @var AccessToken
     */
    public $token;
    /**
     * Extracted user data from the oauth response.
     *
     * @var
     */
    public $user;
    /**
     * Tells if the state is callback (that is if the data is incoming.)
     *
     * @var bool
     */
    public $is_callback = false;
    // END response data

    protected $client;
    protected static $instances;

    const provider_github = 'github';
    const provider_bitbucket = 'bitbucket';

    public static $table = 'users_providers';
    public static $db = 'default';

    /**
     * @param $provider
     *
     * @return \Gf\Auth\OAuth
     */
    public static function instance ($provider) {
        if (!isset(static::$instances[$provider]) or null === static::$instances[$provider]) {
            static::$instances[$provider] = new static($provider);
        }

        return static::$instances[$provider];
    }

    /**
     * Get the callback url for the provider.
     *
     * @param $provider
     *
     * @return string
     */
    public static function getCallbackUrl ($provider) {
        return Uri::create('oauth/authorize/' . $provider);
    }

    /**
     * Get the name of the provider
     *
     * @param $provider
     *
     * @return string
     */
    public static function getProviderName ($provider) {
        if ($provider == self::provider_bitbucket)
            return 'Bitbucket';
        elseif ($provider == self::provider_github)
            return 'Github';
        else
            return (string)$provider;
    }

    protected function __construct ($provider) {
        if ($provider != self::provider_github and $provider != self::provider_bitbucket)
            throw new UserException("The oAuth application $provider is unknown");

        if ($provider == self::provider_github) {
            $this->oauthApplicationConfig = Config::instance()->get('github', false);
        } elseif ($provider == self::provider_bitbucket) {
            $this->oauthApplicationConfig = Config::instance()->get('bitbucket', false);
        } else {
            throw new UserException("The oAuth application $provider is invalid");
        }

        if (!$this->oauthApplicationConfig)
            throw new UserException("oAuth application for $provider was not found");

        $this->provider = $provider;
        $this->callbackUrl = self::getCallbackUrl($this->provider);
        $this->client = new Client();
    }

    public function init () {
        $provider = $this->getDriver();

        if (!isset($_GET['code'])) {
            // step 1. redirect the user to the login site.
            $redirect_url = $provider->getAuthorizationUrl($this->oauthApplicationOptions);
            \Session::set('oauth2state', $provider->getState());
            \Response::redirect($redirect_url);
        } elseif (empty($_GET['state']) || $_GET['state'] != \Session::get('oauth2state')) {
            // invalid state
            \Session::delete('oauth2state');
            throw new AppException('oAuth state mismatch, the request does not match the response');
        } elseif ($this->isError()) {
            // error here
            throw new AppException($this->getError());
        } else {
            // successful callback
            $this->is_callback = true;
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code'],
            ]);
            $this->token = $token;

            $resourceOwner = $provider->getResourceOwner($token);
            $this->user = $this->parseUserData($resourceOwner->toArray());

            /*
             * Bitbucket
             * Token -> values -> scope 'webhook project account'
             */
            $user_id = Auth::instance()->user_id;

            if (!$user_id) {
                throw new UserException('Please login to your account to connect via a oAuth application');
            }

            // at this moment user_id should be available, either existing or newly created.
            $provider = $this->getProviders([
                'provider'  => $this->provider,
                'parent_id' => $user_id,
            ]);
            if ($provider) {
                // we will overwrite the existing provider.
                self::updateProvider([
                    'provider'  => $this->provider,
                    'parent_id' => $user_id,
                ], [
                    'uid'           => $this->user['uid'],
                    'username'      => $this->user['username'],
                    'access_token'  => serialize($this->token),
                    'expires'       => $this->token->getExpires(),
                    'refresh_token' => $this->token->getRefreshToken(),
                    'updated_at'    => Utils::timeNow(),
                ]);
            } else {
                self::insertProvider($user_id, $this->provider, [
                    'uid'           => $this->user['uid'],
                    'username'      => $this->user['username'],
                    'access_token'  => serialize($this->token),
                    'expires'       => $this->token->getExpires(),
                    'refresh_token' => $this->token->getRefreshToken(),
                    'created_at'    => Utils::timeNow(),
                ]);
            }
        }
    }

//    public function refreshToken ($provider) {
//        $driver = $this->getDriver();
//        $access_token = $this->getProviders($this->provider, 'access_token');
//        $token = unserialize($access_token);
//        $refresh_token = $token->getRefreshToken();
//        $new_token = $driver->getAccessToken('refresh_token', [
//            'refresh_token' => $refresh_token,
//        ]);
//        $this->updateProvider($this->provider, [
//            'access_token' => serialize($new_token),
//        ]);
//
//        return $new_token;
//    }

    /**
     * Make data consistent from the response.
     *
     * @param $data
     *
     * @return array
     */
    private function parseUserData ($data) {
        $d = [];

        switch ($this->provider) {
            case self::provider_github:
                $d = [
                    'username' => strtolower($data['login']),
                    'name'     => $data['name'],
                    'uid'      => $data['id'],
                ];
                break;
            case self::provider_bitbucket:
                $d = [
                    'username' => strtolower($data['username']),
                    'name'     => $data['display_name'],
                    'uid'      => $data['uuid'],
                ];
                break;
        }

        return $d;
    }

    public function isError () {
        return isset($_GET['error']);
    }

    public function getError () {
        return $_GET['error'];
    }

    /**
     * Get parsed driver, to use directly.
     *
     * @return \League\OAuth2\Client\Provider\Github|\Stevenmaguire\OAuth2\Client\Provider\Bitbucket
     * @throws \Gf\Exception\AppException
     */
    private function getDriver () {
        switch ($this->provider) {
            case self::provider_github:
                $this->oauthApplicationOptions['scope'] = 'repo,user:email,admin:repo_hook,admin:org_hook';
                $driver = new Github([
                    'clientId'     => $this->oauthApplicationConfig['clientId'],
                    'clientSecret' => $this->oauthApplicationConfig['clientSecret'],
                    'redirectUri'  => $this->callbackUrl,
                ]);
                break;
            case OAuth::provider_bitbucket:
                $driver = new Bitbucket([
                    'clientId'     => $this->oauthApplicationConfig['clientId'],
                    'clientSecret' => $this->oauthApplicationConfig['clientSecret'],
                    'redirectUri'  => $this->callbackUrl,
                ]);
                break;
            default:
                throw new AppException('Driver not found for ' . $this->provider);
        }

        return $driver;
    }


    public static function getProviders (Array $where, $select = null) {
        $a = \DB::select_array($select)
            ->from(self::$table)
            ->where($where)->execute(self::$db)
            ->as_array();

        return count($a) ? $a : false;
    }

    public static function updateProvider (Array $where, $set) {
        return \DB::update(self::$table)
            ->where($where)
            ->set($set)
            ->execute(self::$db);
    }

    public static function insertProvider ($parent_id, $provider, Array $set) {
        $set['parent_id'] = $parent_id;
        $set['provider'] = $provider;
        list($a) = \DB::insert(self::$table)
            ->set($set)
            ->execute(self::$db);

        return $a;
    }

    public static function getConnectedAccounts ($user_id, $select = null) {
        $a = DB::select_array($select)->from(self::$table)->where([
            'parent_id' => $user_id,
        ])->execute(self::$db)->as_array();

        return count($a) ? $a : false;
    }
}