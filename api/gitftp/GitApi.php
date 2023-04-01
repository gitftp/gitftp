<?php

use App\Exceptions\AppException;
use Illuminate\Support\Facades\DB;

class GitApi {

    private $accountId;

    public function __construct($accountId) {
        $this->accountId = $accountId;

        $this->prepare();
    }


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
                $driver = $o->getDriver();
                $refreshToken = $this->token->getRefreshToken();
                $newToken = $driver->getAccessToken('refresh_token', [
                    'refresh_token' => $refreshToken,
                ]);
                // update this token
                DB::table('oauth_app_accounts')
                  ->where([
                      'oauth_app_id' => $this->accountId,
                  ])
                  ->update([
                      'access_token'  => serialize($newToken),
                      'token'         => $newToken->getToken(),
                      'expires'       => $newToken->getExpires(),
                      'refresh_token' => $newToken->getRefreshToken(),
                      'updated_at'    => \App\Models\Helper::getDateTime(),
                  ]);
                // @todo im here.
                //                $token = $oAuth->getr
            }
        }
    }

    /**
     * @var \League\OAuth2\Client\Token\AccessTokenInterface
     */
    private $token;
}
