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

class AuthController extends Controller {
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

    /**
     * Save the config that is provided,
     * in a new .env file. copy from .env-placeholder
     *
     * @param Request $request
     *
     * @return array
     */
    public function saveSetup(Request $request) {
        try {
            $db = $request->database;

            \Config::instance()
                   ->set('mysql.host', $db['host'])
                   ->set('mysql.port', $db['port'])
                   ->set('mysql.database', $db['database'])
                   ->set('mysql.username', $db['username'])
                   ->set('mysql.password', $db['password'])
                   ->set('mysql.socket', $db['socket'])
                   ->save();

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


    public function doSetup(Request $request) {
        try {
            $user = $request->user;
            Artisan::call('migrate');

            // create users here
            $userId = User::create($user['email'], $user['password']);

            $token = User::generateToken($userId);

            \Config::instance()->set('setup', '1')->save();

            $r = [
                'status'  => true,
                'data'    => [
                    'token' => $token,
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

    public function dbTest(Request $request) {
        try {

            $host = $request->host;
            $username = $request->username;
            $password = $request->password;
            $port = $request->port;
            $database = $request->database;

            $conn = Helper::testDatabaseConnection($host, $database, $username, $password, $port);

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

    public function dependencyCheck(Request $request) {
        try {
            $deps = Helper::dependenciesCheck();
            $setup = \Config::instance()
                            ->get('setup', false);
            if ($setup) {
                throw new UserException("The app has already been setup.");
            };
            $r = [
                'status'  => true,
                'data'    => $deps,
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

    public function checkState(Request $request) {
        try {
            $setup = \Config::instance()
                            ->get('setup', false);

            if (!$setup) {
                // if the database is setup, then we go forward
                $nextPage = 'setup';
            }
            else {
                // check if user if logged in
                $nextPage = 'login';
            }

            $r = [
                'status'  => true,
                'data'    => [
                    'nextPage' => $nextPage,
                ],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'data'      => [],
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
            ];
        }

        return $r;
    }
}
