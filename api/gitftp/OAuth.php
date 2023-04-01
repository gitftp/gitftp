<?php

use Illuminate\Support\Facades\DB;

class OAuth {

    const GITHUB = 'github';
    const BITBUCKET = 'bitbucket';

    private $appId;
    private $accountId;

    /**
     * @param array $options [app_id or account_id] in options
     *
     * @throws \App\Exceptions\AppException
     */
    public function __construct(array $options) {

        if (isset($options['account_id'])) {
            $this->accountId = $options['account_id'];
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
                where oaa.account_id = '{${this->accountId}}'
            ");

            if (empty($rows)) {
                throw new \App\Exceptions\AppException('app not found, please try again');
            }

            $this->app = $rows[0];
            $this->appId = $this->app->oauth_app_id;
        }
        elseif (isset($options['app_id'])) {
            $this->appId = $appId;
            //        if($provider != self::GITHUB and $provider )
            $apps = DB::select("
                select
                    oa.client_id,
                    oa.client_secret,
                    p.provider_key
                    from oauth_apps oa
                    inner join providers p on oa.provider_id = p.provider_id
                    where oa.oauth_app_id = '$appId'
            ");

            if (empty($apps)) {
                throw new \Exception('app not found, please try again');
            }

            $this->app = $apps[0];
        }
        else {
            // invalid options
        }


        //        $this->appConfig =
    }

    private function getCallbackUrl() {
        $appId = \App\Models\Helper::encode($this->appId);
        $token = \App\Models\User::getLoggedInUserToken();
        $r = \Illuminate\Support\Facades\URL::to("connect");

        return $r;
    }

    //    https://github.com/login/oauth/authorize?scope=repo%2Cuser%3Aemail%2Cadmin%3Arepo_hook%2Cadmin%3Aorg_hook&state=4b7c7ffe849ed23e331f7c4754b56882&response_type=code&approval_prompt=auto&redirect_uri=http%3A%2F%2Fgf.local%2Fapi%2Fconnect&client_id=0
    //    https://github.com/login/oauth/authorize?scope=repo%2Cuser%3Aemail%2Cadmin%3Arepo_hook%2Cadmin%3Aorg_hook&state=e85258a0e1c4838bfdc2402ba06c5c77&response_type=code&approval_prompt=auto&redirect_uri=http%3A%2F%2Fgf.bon1.in%2Foauth%2Fauthorize%2Fgithub&client_id=174eb32a55553a324d5f

    // client id and secret.
    public $app = [];

    private $appOptions = [];

    public function getDriver() {
        switch ($this->app->provider_key) {
            case 'github':
                $this->appOptions['scope'] = 'repo,user:email,admin:repo_hook,admin:org_hook';
                $driver = new \League\OAuth2\Client\Provider\Github([
                    'clientId'     => $this->app->client_id,
                    'clientSecret' => $this->app->client_secret,
                    'redirectUri'  => $this->getCallbackUrl(),
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

    const CONFIG_OAUTHSTATE = 'oauth2state';

    private $isCallback = false;

    public function getAppOptions() {
        return $this->appOptions;
    }

    public function init() {
        $driver = $this->getDriver();
        $request = app('request');

        if (!$request->code) {
            $redirectUrl = $driver->getAuthorizationUrl($this->appOptions);
            $state = $driver->getState();
            Config::instance()
                  ->set(self::CONFIG_OAUTHSTATE . '.' . $state, [
                      'app_id' => $this->appId,
                  ])
                  ->save();
            header('Location: ' . $redirectUrl);
            ob_flush();
            flush();
            die;
        }
        elseif (!$request->state) {
            throw new \Exception('OAuth state mismatched');
        }
        elseif ($request->error) {
            throw new \Exception($request->error);
        }
        else {
            $this->isCallback = true;
            $request->state;
            $token = $driver->getAccessToken('authorization_code', [
                'code' => $request->code,
            ]);
            $this->token = $token;

            $owner = $driver->getResourceOwner($token);
            //            $this->user = $this->parseUserData($owner->toArray());
            $gitUsername = $owner->login;
            $gitName = $owner->name;
            $gitUid = $owner->id;
        }
    }

    private $token;


}

//https://github.com/login/oauth/authorize?state=5afb7e7ea6ad3463c33e49e19476fd26&response_type=code&approval_prompt=auto&client_id=174
