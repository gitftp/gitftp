<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use App\Models\Helper;
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
            try {
                $env = file_get_contents(base_path() . '/.env-placeholders');
            } catch (\Exception $e) {
                throw new \Exception('[5067] .env-placeholder file not found.');
            }

            $env = str_replace([
                '{host}',
                '{port}',
                '{database}',
                '{username}',
                '{password}',
            ], [
                $db['host'],
                $db['port'],
                $db['database'],
                $db['username'],
                $db['password'],
            ], $env);
            try {
                file_put_contents(base_path() . '/.env', $env);
            } catch (\Exception $e) {
                throw new \Exception('[5068] Could not write .env file', 0, $e);
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



    public function doSetup(Request $request) {
        try {
            $user = $request->user;
            DB::statement("create table `options`
(
    option_id int auto_increment primary key,
    name      varchar(40) null,
    value     longtext    null
)
    charset = utf8mb4;
");
//            Artisan::call('migrate');
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
            if (!env('DB_USERNAME')) {
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
