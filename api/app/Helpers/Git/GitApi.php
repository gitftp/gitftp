<?php

namespace App\Helpers\Git;

use App\Exceptions\AppException;
use App\Helpers\Git\GitApi\Github;
use App\Helpers\Git\GitApi\GitProviderInterface;
use App\Helpers\OAuth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Api interface for Git providers
 */
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


    /**
     * creates url that is used for clone,
     * this clone url uses token for authentication
     *
     * @param $clone_url
     *
     * @return string
     * @throws AppException
     */
    public function createAuthCloneUrl ($clone_url): string {
        $token = $this->token->getToken();

        if ($this->account->provider_key == OAuth::BITBUCKET) {
            $username = "x-token-auth";
            $password = $token;
        } elseif ($this->account->provider_key == OAuth::GITHUB) {
            $username = $this->account->git_username; // i doubt this
            $password = $token;
        } else {
            throw new AppException("Invalid provider");
        }

        $repo_url = parse_url($clone_url);
        $repo_url['user'] = $username;

        if ($password) {
            $repo_url['pass'] = $password;
        }
        $url = http_build_url($repo_url);

        return $url;
    }

}
