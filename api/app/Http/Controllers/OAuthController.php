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

    public function connect(Request $request) {
        try {

            $id = $request->me;
            $id = Helper::decode($id);

            try {
                $o = \OAuth::getInstance($id);
                try {
                    $o->init();
                } catch (\Exception $e) {
                    throw $e;

                }

            } catch (\Exception $e) {
                throw $e;
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

            DB::table('oauth_apps')
              ->insert([
                  'provider_id'   => $providerId,
                  'client_id'     => $clientId,
                  'client_secret' => $clientSecret,
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
