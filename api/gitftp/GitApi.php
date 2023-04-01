<?php

use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Token\AccessToken;

class GitApi {

    private $accountId;

    public function __construct($accountId) {
        $this->accountId = $accountId;
        $this->prepare();
    }


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
    }

    /**
     * @var AccessToken
     */
    private $token;
}
