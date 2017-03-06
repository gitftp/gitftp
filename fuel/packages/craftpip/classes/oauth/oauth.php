<?php

namespace Craftpip\OAuth;

use Craftpip\Exception;
use Gf\Settings;

/**
 * Wrapper class to validate Oauth logins.
 *
 * @deprecated
 * Class Oauth
 * @package Craftpip\Oauth
 */
class OAuth extends Auth {
    public $config = array();
    public $OAuth_provider;
    public $OAuth_providerConfig;
    public $OAuth_callbackUrl;
    public $OAuth_scope = array();
    public $OAuth_token;
    public $OAuth_user;
    public $OAuth_email = NULL;
    public $OAuth_state = NULL;
    public $OAuth_is_callback = FALSE;
    protected $client;

    public function __construct($user_id = NULL) {
        parent::__construct($user_id);
        $this->client = new \GuzzleHttp\Client();
    }

    public function parseUserData($data) {
        switch ($this->OAuth_provider) {
            case 'GitHub':
                $data = [
                    'username' => $data['login'],
                    'name'     => $data['name'],
                    'uid'      => $data['id'],
                    'location' => $data['location'],
                    'email'    => $data['email'],
                ];
                break;
            case 'Bitbucket':
                $data = [
                    'username' => $data['username'],
                    'name'     => $data['display_name'],
                    'uid'      => $data['uuid'],
                    'location' => $data['location'],
                    'email'    => NULL // bitbucket doesnt return Email.
                ];
                break;
        }

        return $data;
    }

    public function is_error() {
        $error = FALSE;
        if (isset($_GET['error'])) {
            $error = TRUE;
        }

        return $error;
    }

    public function refreshToken($provider) {
        $this->OAuth_provider = $this->_parseProviderName($provider);
        $driver = $this->getDriver();
        $token = $this->getToken($provider);
        $refresh_token = $token->getRefreshToken(); // refresh token used to retrive the new token.
        $new_token = $driver->getAccessToken('refresh_token', [
            'refresh_token' => $refresh_token
        ]);
        $this->updateProvider($this->OAuth_provider, [
            'access_token' => serialize($new_token)
        ]);

        return $new_token;
    }

    public function init($provider, $refUrl = NULL) {
        $provider = $this->_parseProviderName($provider);
        $this->OAuth_provider = $provider;
        $this->OAuth_callbackUrl = \Uri::current();
        $provider = $this->getDriver();

        if (!isset($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl($this->OAuth_scope);
            \Session::set('oauth2state', $provider->getState());
//            \Session::set('oauth2state_ref', $refUrl);
            \Response::redirect($authUrl);

        } elseif (empty($_GET['state']) || $_GET['state'] != \Session::get('oauth2state')) {
            \Session::delete('oauth2state');
//            \Session::delete('oauth2state_ref');
        } elseif ($this->is_error()) {
            //todo: error if request is denied.
        } else {
            $this->OAuth_is_callback = TRUE;
            $token = $provider->getAccessToken('authorization_code', array(
                'code' => $_GET['code']
            ));
            $this->OAuth_token = $token;
            $resourceOwner = $provider->getResourceOwner($token);
            $this->OAuth_user = $this->parseUserData($resourceOwner->toArray());
            $this->getAdditionalData();
            $this->processCallback();
        }
    }

    public function getAdditionalData() {
        switch ($this->OAuth_provider) {
            case 'Bitbucket':
                $res = $this->client->get('https://api.bitbucket.org/2.0/user/emails', [
                    'headers' => ['Authorization' => 'Bearer ' . $this->OAuth_token->getToken()]
                ]);
                $data = json_decode($res->getBody(), TRUE)['values'];
                foreach ($data as $emails) {
                    if ($emails['is_primary'] == 1) {
                        $this->OAuth_email = $emails['email'];
                    }
                }
                break;
            case 'GitHub':
                $this->OAuth_email = $this->OAuth_user['email'];
        }

        if (is_null($this->OAuth_email)) {
            throw new Exception('Something is not right.');
        }
    }

    public function login_or_register() {
        return $this->OAuth_state;
    }

    public function processCallback() {
        if ($this->user_id != 0) {
            // meaning, the user is already logged in.
            $this->OAuth_state = 'logged_in';
        } else {
            // user is not logged in.

            $user = $this->getUserByProviderUID($this->OAuth_user['uid']);
            // check if user is registered by this provider UID.

            if (!$user)
                $user = $this->getByUsernameEmail($this->OAuth_email);

            if ($user) {
                $user_id = $user['id'];
                $this->setId($user_id); // set User ID here.
                $this->OAuth_state = 'logged_in';
            } else {
                $user_id = $this->create_user(
                    $this->OAuth_user['username'],
                    \Str::random(),
                    $this->OAuth_email,
                    Settings::get('oauth_default_group'),
                    array()
                );
                $this->setId($user_id);
                $this->OAuth_state = 'registered';
            }
        }

        $provider = $this->getProviders($this->OAuth_provider);
        if ($provider) {
            // we will overwrite the existing provider.
            $this->updateProvider($this->OAuth_provider, [
                'uid'           => $this->OAuth_user['uid'],
                'username'      => $this->OAuth_user['username'],
                'access_token'  => serialize($this->OAuth_token),
                'expires'       => $this->OAuth_token->getExpires(),
                'refresh_token' => $this->OAuth_token->getRefreshToken(),
                'updated_at'    => time(),
            ]);
        } else {
            $this->insertProvider($this->OAuth_provider, [
                'parent_id'     => $this->user_id,
                'uid'           => $this->OAuth_user['uid'],
                'username'      => $this->OAuth_user['username'],
                'access_token'  => serialize($this->OAuth_token),
                'expires'       => $this->OAuth_token->getExpires(),
                'refresh_token' => $this->OAuth_token->getRefreshToken(),
                'created_at'    => time(),
            ]);
            if ($this->OAuth_state == 'logged_in')
                $this->OAuth_state = 'linked';
        }
        $this->force_login($this->user_id);
    }

    public function getDriver() {
        switch (strtolower($this->OAuth_provider)) {
            case 'github':
                $this->OAuth_scope = [
                    'scope' => explode(',', Settings::get('oauth_provider_github_scope'))
                ];
                $driver = new \League\OAuth2\Client\Provider\Github([
                    'clientId'     => Settings::get('oauth_provider_github_client_id'),
                    'clientSecret' => Settings::get('oauth_provider_github_client_secret'),
                ]);
                break;
            case 'bitbucket':
                $driver = new \Stevenmaguire\OAuth2\Client\Provider\Bitbucket([
                    'clientId'     => Settings::get('oauth_provider_bitbucket_key'),
                    'clientSecret' => Settings::get('oauth_provider_bitbucket_secret'),
                    'redirectUri'  => $this->OAuth_callbackUrl,
                ]);
                break;
            default:
                throw new Exception('Driver not found for ' . $this->OAuth_provider);
        }

        return $driver;
    }

}