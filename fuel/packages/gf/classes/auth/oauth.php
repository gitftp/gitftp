<?php

namespace Nb\Auth;

use Gf\Exception\UserException;
use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\Google;
use Gf\Exception\AppException;
use Gf\Settings;
use \GuzzleHttp\Client as Client;

/**
 * Class OAuth
 * Wrapper class to validate OAUTH logins.
 *
 * @property  instance
 * @package Nb\Auth
 */
class OAuth {
    public $config = [];
    public $provider;
    public $providerConfig;
    public $callbackUrl;
    public $scope = [];
    public $token;
    public $user;
    public $email = null;
    public $state = null;
    public $is_callback = false;

    public static $state_logged_in = 'logged_in';
    public static $state_linked = 'linked';
    public static $state_registered = 'registered';
    public static $state_not_a_customer = 'not_a_customer';
    public static $state_account_not_active = 'not_active';

    protected $client;
    protected static $instances;

    const provider_github = 'github';
    const provider_bitbucket = 'bitbucket';

    public static $table = 'users_providers';
    public static $db = 'default';

    public $user_id = null;

    /**
     * @param $provider
     *
     * @return \Nb\Auth\OAuth
     */
    public static function instance ($provider) {
        if (!isset(static::$instances[$provider]) or null === static::$instances[$provider]) {
            static::$instances[$provider] = new static($provider);
        }

        return static::$instances[$provider];
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
            throw new UserException('The provider is not known: given ' . $provider);

        $this->provider = $provider;
        $this->client = new Client();
    }

    public function init () {
        $this->callbackUrl = \Uri::current();
        $provider = $this->getDriver();

        if (!isset($_GET['code'])) {
            // step 1.
            $redirect_url = $provider->getAuthorizationUrl($this->scope);
            \Session::set('oauth2state', $provider->getState());
            \Response::redirect($redirect_url);
        } elseif (empty($_GET['state']) || $_GET['state'] != \Session::get('oauth2state')) {
            // whoops invalid state.
            \Session::delete('oauth2state');
        } elseif ($this->is_error()) {
            // error here
        } else {
            // successful callback
            $this->is_callback = true;
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code'],
            ]);
            $this->token = $token;
            $resourceOwner = $provider->getResourceOwner($token);
            $this->user = $this->parseUserData($resourceOwner->toArray());
            $this->processCallback();
        }
    }

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
            case self::$provider_facebook:
                $d = [
                    'username' => strtolower($data['first_name']),
                    'name'     => $data['name'],
                    'uid'      => $data['id'],
                    'email'    => $data['email'],
                ];
                $this->email = $d['email'];
                break;
            case self::$provider_google:
                $d = [
                    'username' => strtolower($data['name']['familyName']),
                    'name'     => $data['displayName'],
                    'uid'      => $data['id'],
                    'email'    => $data['emails'][0]['value'],
                ];
                $this->email = $d['email'];
                break;
        }

        return $d;
    }

    public function is_error () {
        return isset($_GET['error']);
    }

    public function get_state () {
        return $this->state;
    }

    private function processCallback () {
        $auth_instance = Auth::instance();

        if ($auth_instance->user_id) {
            // the user is logged in.
            $this->state = self::$state_logged_in;
            $this->user_id = $auth_instance->user_id;
        } else {
            // user is not logged in.

            // if not there in providers, check in users.

            // get the user if exists.
            $user = $auth_instance->get_one([
                'email' => $this->email,
            ]);

            // if the user doesn't exists. create it.
            if (!$user) {
                // creating new user here.

                $user_id = Users::instance()
                    ->create_user(
                        null,
                        $this->email,
                        null,
                        \Str::random(),
                        Settings::get('oauth_default_group', 1),
                        [
                            'account_active' => 1,
                            'email_verified' => 1,
                        ],
                        []
                    );

                $user = $auth_instance->get_one([
                    'id' => $user_id,
                ]);
                $this->user_id = $user['id'];
                $this->state = self::$state_registered;
            } else {
                $this->user_id = $user['id'];
                $this->state = self::$state_logged_in;
            }
        }

        // at this moment user_id should be available, either existing or newly created.
        $provider = $this->getProviders($this->provider);
        if ($provider) {
            // we will overwrite the existing provider.
            $this->updateProvider($this->provider, [
                'uid'           => $this->user['uid'],
                'username'      => $this->user['username'],
                'access_token'  => serialize($this->token),
                'expires'       => $this->token->getExpires(),
                'refresh_token' => $this->token->getRefreshToken(),
                'updated_at'    => \Utils::timeNow(),
            ]);
        } else {
            $this->insertProvider($this->provider, [
                'parent_id'     => $this->user_id,
                'uid'           => $this->user['uid'],
                'username'      => $this->user['username'],
                'access_token'  => serialize($this->token),
                'expires'       => $this->token->getExpires(),
                'refresh_token' => $this->token->getRefreshToken(),
                'created_at'    => \Utils::timeNow(),
            ]);
            if ($this->state == self::$state_logged_in)
                $this->state = self::$state_linked;
        }

        $selected_user_instance = Auth::instance($this->user_id);

        if ($selected_user_instance->user['account_active'] == 0) {
            $this->state = self::$state_account_not_active;
        } else {
            if ($selected_user_instance->member(Users::$customer) || $selected_user_instance->member(Users::$retailCustomer)) {
                $session = $selected_user_instance->force_login();
                SessionManager::instance()
                    ->create_snapshot($session);
            } else {
                $this->state = self::$state_not_a_customer;
            }
        }

    }

    /**
     * Get parsed driver, to use directly.
     *
     * @return Facebook|Google
     * @throws AppException
     */
    private function getDriver () {
        switch (strtolower($this->provider)) {
            case OAuth::$provider_facebook:
                $this->scope = [
                    'scope' => explode(',', Settings::get('oauth_provider_facebook_scope')),
                ];
                $driver = new Facebook([
                    'clientId'        => Settings::get('oauth_provider_facebook_client_id'),
                    'clientSecret'    => Settings::get('oauth_provider_facebook_client_secret'),
                    'redirectUri'     => $this->callbackUrl,
                    'graphApiVersion' => 'v2.5',
                ]);
                break;
            case OAuth::$provider_google:
                $driver = new Google([
                    'clientId'     => Settings::get('oauth_provider_google_client_id'),
                    'clientSecret' => Settings::get('oauth_provider_google_client_secret'),
                    'redirectUri'  => $this->callbackUrl,
                    'hostedDomain' => home_url,
                ]);
                break;
            default:
                throw new AppException('Driver not found for ' . $this->provider);
        }

        return $driver;
    }

    private function getProviders ($provider_name = null, $column_name = null) {
        $a = \DB::select()
            ->from(self::$table)
            ->where('parent_id', $this->user_id);
        if (!is_null($provider_name)) {
            $a = $a->and_where('provider', $provider_name);
        }
        $b = $a->execute(self::$db)
            ->as_array();

        if (is_null($provider_name)) {
            return $b;
        } else {
            if (is_null($column_name)) {
                return count($b) ? $b[0] : false;
            } else {
                return isset($b[0][$column_name]) ? $b[0][$column_name] : false;
            }
        }
    }

    private function updateProvider ($name, $set) {
        return \DB::update(self::$table)
            ->where('parent_id', $this->user_id)
            ->and_where('provider', $name)
            ->set($set)
            ->execute(self::$db);
    }

    private function insertProvider ($name, $set) {
        $set['parent_id'] = $this->user_id;
        $set['provider'] = $name;
        list($a) = \DB::insert(self::$table)
            ->set($set)
            ->execute(self::$db);

        return $a;
    }
}