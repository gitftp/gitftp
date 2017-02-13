<?php

class Controller_Setup_Api extends Controller_Rest {

    public function post_dep_test () {
        try {

            $php = 2;
            if (version_compare(PHP_VERSION, '5.3', '>=')) {
                $php = 1;
            }

            $git_version = false;
            $git = 2;
            $op = exec('git --version');
            if (strpos($op, 'git version') !== false) {
                $git = 1;
                $git_version = str_replace($op, 'git version', '');
            }

            $r = [
                'status' => true,
                'data'   => [
                    'php' => [$php, PHP_VERSION],
                    'git' => [$git, $git_version],
                ],
            ];
        } catch (\Exception $e) {
//            $e = \Nb\Exception\ExceptionInterceptor::intercept($e);
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


            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
//            $e = \Nb\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }
}
