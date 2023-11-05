<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class OAuth
{

    const GITHUB = 'github';
    const BITBUCKET = 'bitbucket';
    const CONFIG_OAUTHSTATE = 'oauth2state';

    private $appId;
    private $accountId;
    public $app = [];
    /**
     * Driver options
     * @var array
     */
    private $appOptions = [];

    /**
     * @param array $options [app_id or account_id] in options
     *
     * @throws \App\Exceptions\AppException
     */
    public function __construct(array $options)
    {
        if (isset($options['account_id'])) {
            $accountId = $this->accountId = $options['account_id'];
            //        if($provider != self::GITHUB and $provider )
            $rows = DB::select("
                select
                    oa.client_id,
                    oa.client_secret,
                    p.provider_key,
                    oa.oauth_app_id
                    from oauth_app_accounts oaa
                    inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
                    inner join providers p on oa.provider_id = p.provider_id
                where oaa.account_id = '$accountId'
            ");

            if (empty($rows)) {
                throw new \App\Exceptions\AppException('app not found, please try again');
            }

            $this->app = $appId = $rows[0];
            $this->appId = $this->app->oauth_app_id;
        } elseif (isset($options['app_id'])) {
            $this->appId = $appId = $options['app_id'];
            $rows = DB::select("
                select
                    oa.client_id,
                    oa.client_secret,
                    p.provider_key
                    from oauth_apps oa
                    inner join providers p on oa.provider_id = p.provider_id
                    where oa.oauth_app_id = '$appId'
            ");

            if (empty($rows)) {
                throw new \Exception('app not found, please try again');
            }

            $this->app = $rows[0];
        } else {
            throw new \App\Exceptions\AppException('Invalid request');
        }
    }

    private function getCallbackUrl()
    {
        $r = \Illuminate\Support\Facades\URL::to("connect");

        return $r;
    }

    public function getDriver(): AbstractProvider
    {
        switch ($this->app->provider_key) {
            case 'github':
                $this->appOptions['scope'] = 'repo,user:email,admin:repo_hook,admin:org_hook';
                $driver = new \League\OAuth2\Client\Provider\Github([
                    'clientId' => $this->app->client_id,
                    'clientSecret' => $this->app->client_secret,
                    'redirectUri' => $this->getCallbackUrl(),
                ]);
                break;
            case 'bitbucket':
                //                $driver = new Bitbucket([
                //                    'clientId' => $this->app['client_id'],
                //                    'clientSecret' => $this->app['client_secret'],
                //                ]);
                break;
            default:
                throw new \Exception('Provider for oAuth app not found');

                break;
        }

        return $driver;
    }

    public function getAppOptions()
    {
        return $this->appOptions;
    }


    public function refreshToken(AccessToken $token)
    {
        if (!$this->accountId)
            throw new \App\Exceptions\AppException('please set account id');


        $driver = $this->getDriver();
        $refreshToken = $token->getRefreshToken();
        $newToken = $driver->getAccessToken('refresh_token', [
            'refresh_token' => $refreshToken,
        ]);
        DB::table('oauth_app_accounts')
            ->where([
                'oauth_app_id' => $this->accountId,
            ])
            ->update([
                'access_token' => serialize($newToken),
                'token' => $newToken->getToken(),
                'expires' => $newToken->getExpires(),
                'refresh_token' => $newToken->getRefreshToken(),
                'updated_at' => \App\Helpers\Helper::getDateTime(),
            ]);

        return $newToken;
    }

    public function redirectForLogin(): void
    {
        $driver = $this->getDriver();
        $redirectUrl = $driver->getAuthorizationUrl($this->getAppOptions());
        $state = $driver->getState();
        self::saveState($state, $this->appId);
        ob_start();
        header('Location: ' . $redirectUrl);
        ob_flush();
        flush();
        die;
    }

    public static function saveState($state, $appId)
    {
        \Config::instance()
            ->set(OAuth::CONFIG_OAUTHSTATE . '.' . $state, [
                'app_id' => $appId,
            ])
            ->save();
    }

    public static function getState($state, $remove = false)
    {
        $s = \Config::instance()
            ->get(OAuth::CONFIG_OAUTHSTATE . '.' . $state);
        if (!$s) {
            throw new \Exception("OAuth previous state was not found. please try again");
        }

        \Config::instance()
            ->remove(OAuth::CONFIG_OAUTHSTATE . '.' . $state);

        return $s;
    }

    public function readLoginResponse($code)
    {
        $driver = $this->getDriver();
        $token = $driver->getAccessToken('authorization_code', [
            'code' => $code,
        ]);
        $owner = $driver->getResourceOwner($token);
        $gitUsername = $owner->getNickname();
        $gitName = $owner->getName();
        $gitUid = $owner->getId();
        $gitEmail = $owner->getEmail();
        $gitUrl = $owner->getUrl();
        $accessToken = serialize($token);
        $justToken = $token->getToken();
        $expires = $token->getExpires();
        $refreshToken = $token->getRefreshToken();

        $appId = $this->appId;
        $exists = DB::select("
                    select * from oauth_app_accounts app
                    where app.git_username = '$gitUsername'
                    and app.oauth_app_id = ''
                ");

        $set = [
            'oauth_app_id' => $appId,
            'git_username' => $gitUsername,
            'git_name' => $gitName,
            'git_uid' => $gitUid,
            'git_email' => $gitEmail,
            'git_url' => $gitUrl,
            'access_token' => $accessToken,
            'token' => $justToken,
            'expires' => $expires,
            'refresh_token' => $refreshToken,
            'created_at' => \App\Helpers\Helper::getDateTime(),
            'created_by' => 0,
        ];
        if (count($exists)) {
            DB::table('oauth_app_accounts')
                ->where([
                    'oauth_app_id' => $appId,
                    'git_username' => $gitUsername,
                ])
                ->update($set);
        } else {
            // git username is unique tho
            DB::table('oauth_app_accounts')
                ->insert($set);
        }

        ob_start();
        $site = \Config::instance()->get('public_domain');
        header('Location: ' . $site . 'git-accounts');
        ob_flush();
        flush();
        die;
    }
}

//https://github.com/login/oauth/authorize?state=5afb7e7ea6ad3463c33e49e19476fd26&response_type=code&approval_prompt=auto&client_id=174
