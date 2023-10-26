<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Models\Helper;
use App\Models\OAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OAuthController extends Controller
{
    public function __construct()
    {

    }

    public function example(Request $request)
    {
        try {

            $r = [
                'status' => true,
                'data' => [],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }


    public function deleteGitAccounts(Request $request)
    {
        try {

            $accountId = $request->account_id;
            DB::table('oauth_app_accounts')
                ->where([
                    'account_id' => $accountId,
                ])->delete();

            $r = [
                'status' => true,
                'message' => '',
                'data' => []
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }

    public function gitAccounts(Request $request)
    {
        try {
            $userId = $request->userId;

            $accounts = DB::select("
    select
        oaa.git_username,
        oaa.token as access_token,
        oaa.expires,
        oa.client_id,
        p.provider_name,
        p.provider_key,
        oaa.account_id

    from oauth_app_accounts oaa
    inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
    inner join providers p on oa.provider_id = p.provider_id
    where oa.user_id = '$userId'
            ");

            $r = [
                'status' => true,
                'data' => [
                    'accounts' => $accounts,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }

    public function connect(Request $request)
    {
        try {

            $data = [];
            if (!$request->code and $request->me) {
                // making a request
                $appId = $request->me;
                $appId = Helper::decode($appId);
                $o = new \App\Models\OAuth([
                    'app_id' => $appId,
                ]);
                $data['asd'] = $o->redirectForLogin();
            } elseif (!$request->state) {
                throw new \Exception('OAuth state mismatched');
            } elseif ($request->error) {
                throw new \Exception($request->error);
            } else {
                // receiving a request
                $state = $request->state;
                $code = $request->code;
                $previousState = OAUth::getState($state);
                $appId = $previousState['app_id'];
                $o = new \App\Models\OAuth([
                    'app_id' => $appId,
                ]);
                $o->readLoginResponse($code);
            }

            $r = [
                'status' => true,
                'data' => $data,
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }

    public function saveOauthApp(Request $request)
    {
        try {

            $providerId = $request->provider_id;
            $clientId = $request->client_id;
            $clientSecret = $request->client_secret;

            $userId = $request->userId;

            DB::table('oauth_apps')
                ->insert([
                    'provider_id' => $providerId,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'user_id' => $userId,
                    'created_at' => Helper::getDateTime(),
                    'created_by' => $userId,
                ]);

            $oAuthAppId = Helper::getLastInsertId();

            $originUrl = \Config::instance()->get('public_domain');

            $r = [
                'status' => true,
                'data' => [
                    'app_id' => $oAuthAppId,
                    'public_domain' => $originUrl,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }

    public function allProviders(Request $request)
    {
        try {
            $providers = DB::select("
                select * from providers
            ");

            $r = [
                'status' => true,
                'data' => [
                    'providers' => $providers,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'message' => $e->getMessage(),
                'exception' => $e->getJson(),
                'data' => [],
            ];
        }

        return $r;
    }

}
