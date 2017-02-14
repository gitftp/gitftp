<?php

class Controller_Setup_Api extends Controller_Rest {

    public function post_dep_test () {
        try {
            $dependencies = \Gf\Misc::dependenciesCheck();

            $r = [
                'status' => true,
                'data'   => [
                    'php'   => $dependencies['php'],
                    'git'   => $dependencies['git'],
                    'os'    => $dependencies['os'],
                    'allOk' => $dependencies['ok'],
                ],
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    public function post_db_test () {
        try {
            $host = \Fuel\Core\Input::json('db.host');
            $username = \Fuel\Core\Input::json('db.username');
            $password = \Fuel\Core\Input::json('db.password');
            $dbname = \Fuel\Core\Input::json('db.dbname');

            if (!function_exists('mysqli_connect')) {
                throw new \Gf\Exception\UserException('Mysqli extension was not found, please install the php_mysqli extension');
            }

            $connection = mysqli_connect($host, $username, $password, $dbname);
            if ($error_code = mysqli_connect_errno()) {
                throw new \Gf\Exception\UserException('Error in connecting to MySql Database');
            }

            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }
}
