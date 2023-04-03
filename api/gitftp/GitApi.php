<?php

use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Token\AccessToken;

class GitApi {

    private $accountId;
    private $account;

    public function __construct($accountId) {
        $this->accountId = $accountId;
        $this->prepare();
    }


    private function getAllRepos() {
        //        $this->driver
    }

    /**
     * @var \Craftpip\GitApi\GitApiInterface
     */
    private $provider;

    /**
     * get app,
     * and check if the token has expired.
     * if expired, refresh the token
     *
     * @throws AppException
     */
    private function prepare() {
        $ac = $this->accountId;
        $account = DB::select("
            select
                oaa.access_token,
                oaa.token,
                oaa.refresh_token,
                oaa.git_username,
                p.provider_key

                from oauth_app_accounts oaa
                     inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
                     inner join providers p on oa.provider_id = p.provider_id
            where oaa.account_id = '$ac'
        ");
        if (empty($account)) {
            throw new AppException('Account not found');
        }
        $account = $account[0];
        $this->account = $account;
        $this->token = unserialize($account->access_token);
        $expires = $this->token->getExpires();
        if (!empty($expires)) {
            if ($this->token->hasExpired()) {
                $o = new OAuth([
                    'account_id' => $this->accountId,
                ]);
                $this->token = $o->refreshToken($this->token);
            }
        }
        $this->oauth = new OAuth([
            'account_id' => $this->accountId,
        ]);
        $this->driver = $this->oauth->getDriver();
        $this->driverAppOptions = $this->oauth->getAppOptions();
        switch ($this->account->provider_key) {
            case 'github':
                $this->provider = new Github($this->account->git_username);
                break;
            case 'bitbucket':
                //                $this->provider = new
                break;
            default:
                break;
        }

        $this->provider->authenticate($this->token->getToken());
    }

    /**
     * @return GitProviderInterface
     */
    public function getProvider(): GitProviderInterface {
        return $this->provider;
    }

    private $driverAppOptions;
    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    private $driver;
    /**
     * @var OAuth
     */
    private $oauth;

    /**
     * @var AccessToken
     */
    private $token;
}
