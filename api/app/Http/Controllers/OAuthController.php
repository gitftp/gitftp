<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use App\Models\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OAuthController extends Controller {
    public function __construct() {

    }

    public function example(Request $request) {
        try {

            $r = [
                'status'  => true,
                'data'    => [],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

    public function gitAccounts(Request $request) {
        try {
            $userId = $request->userId;

            $accounts = DB::select("
    select
        oaa.git_username,
        oaa.access_token,
        oaa.expires,
        oa.client_id,
        p.provider_name,
        p.provider_key

    from oauth_app_accounts oaa
    inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
    inner join providers p on oa.provider_id = p.provider_id
    where oa.user_id = '$userId'
            ");

            $r = [
                'status'  => true,
                'data'    => [
                    'accounts' => $accounts,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

    public function connect(Request $request) {
        try {

            //            const CONFIG_OAUTHSTATE = 'asd';


            if (!$request->code) {
                // making a request
                $appId = $request->me;
                $appId = Helper::decode($appId);

                $o = new \OAuth([
                    'app_id' => $appId,
                ]);
                $driver = $o->getDriver();
                $redirectUrl = $driver->getAuthorizationUrl($o->getAppOptions());
                $state = $driver->getState();
                \Config::instance()
                       ->set(\OAuth::CONFIG_OAUTHSTATE . '.' . $state, [
                           'app_id' => $appId,
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
                $state = $request->state;
                $code = $request->code;
                $previousState = \Config::instance()
                                        ->get(\OAuth::CONFIG_OAUTHSTATE . '.' . $state);
                if (!$previousState) {
                    throw new \Exception("OAuth previous state was not found. please try again");
                }
                $appId = $previousState['app_id'];
                $o = new \OAuth([
                    'app_id' => $appId,
                ]);
                $driver = $o->getDriver();
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

                $exists = DB::select("
                    select * from oauth_app_accounts app
                    where app.git_username = '$gitUsername'
                    and app.oauth_app_id = '$appId'
                ");

                $set = [
                    'oauth_app_id'  => $appId,
                    'git_username'  => $gitUsername,
                    'git_name'      => $gitName,
                    'git_uid'       => $gitUid,
                    'git_email'     => $gitEmail,
                    'git_url'       => $gitUrl,
                    'access_token'  => $accessToken,
                    'token'  => $justToken,
                    'expires'       => $expires,
                    'refresh_token' => $refreshToken,
                    'created_at'    => Helper::getDateTime(),
                    'created_by'    => 0,
                ];
                if (count($exists)) {
                    DB::table('oauth_app_accounts')
                      ->where([
                          'oauth_app_id' => $appId,
                          'git_username' => $gitUsername,
                      ])
                      ->update($set);
                }
                else {
                    // git username is unique tho
                    DB::table('oauth_app_accounts')
                      ->insert($set);
                }

                \Config::instance()
                       ->remove(\OAuth::CONFIG_OAUTHSTATE . '.' . $state);
                header('Location: http://localhost:4200/git-accounts');
                ob_flush();
                flush();
                die;
            }


            $r = [
                'status'  => true,
                'data'    => [],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

    public function saveOauthApp(Request $request) {
        try {

            $providerId = $request->provider_id;
            $clientId = $request->client_id;
            $clientSecret = $request->client_secret;

            $userId = $request->userId;

            DB::table('oauth_apps')
              ->insert([
                  'provider_id'   => $providerId,
                  'client_id'     => $clientId,
                  'client_secret' => $clientSecret,
                  'user_id'       => $userId,
                  'created_at'    => Helper::getDateTime(),
                  'created_by'    => $userId,
              ]);

            $oAuthAppId = Helper::getLastInsertId();

            $r = [
                'status'  => true,
                'data'    => [
                    'app_id' => $oAuthAppId,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

    public function allProviders(Request $request) {
        try {
            $providers = DB::select("
                select * from providers
            ");

            $r = [
                'status'  => true,
                'data'    => [
                    'providers' => $providers,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

}
