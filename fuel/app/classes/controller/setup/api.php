<?php

use Fuel\Core\Input;

class Controller_Setup_Api extends Controller_Rest {
    /**
     * Do a dependency test
     */


//    public function before () {
//        parent::before();
//        if (\Gf\Config::instance()->get('ready')) {
//            echo 'The sites is setup.';
//            die;
//        }
//    }

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
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    /**
     * Test in incoming database config and set it in the configs
     */
    public function post_db_setup () {
        try {


            $host = Input::json('db.host');
            $username = Input::json('db.username');
            $password = Input::json('db.password');
            $db_name = Input::json('db.dbname');
            // ready. install the schema to database here.
            \Gf\Misc::testDatabase($host, $db_name, $username, $password);

            \Gf\Config::instance()->set([
                'mysql.host'     => $host,
                'mysql.username' => $username,
                'mysql.password' => $password,
                'mysql.dbname'   => $db_name,
            ])->save();

            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    /**
     * Save the oauth config provided.
     */
    public function post_save_oauth_config () {
        try {
            $provider = Input::json('provider', false);
            $clientId = Input::json('config.clientId', false);
            $clientSecret = Input::json('config.clientSecret', false);

            if (!$provider or !$clientId or !$clientSecret)
                throw new \Gf\Exception\UserException('The given parameters are wrong');

            if ($provider == 'github' || $provider == 'bitbucket') {
                $set = [
                    "$provider.clientId"     => $clientId,
                    "$provider.clientSecret" => $clientSecret,
                ];
            } else {
                throw new \Gf\Exception\UserException("Don't know about this provider yet.");
            }

            \Gf\Config::instance()->set($set)->save();

            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    /**
     * After the database is setup, create the administrative account
     */
    public function post_create_user () {
        try {
            // at this point the database config must be there in the config file.
            if (!GF_CONFIG_FILE_EXISTS)
                throw new \Gf\Exception\UserException('The configuration file does not exists');

            $email = Input::json('user.email');
            $password = Input::json('user.password');

            // user adding stuff
            $users = \Gf\Auth\Users::instance();
            // there can be only one superadmin
            // remove the other ones
            $users->remove([
                'group' => \Gf\Auth\Users::$administrator,
            ]);
            $user_id = $users->create_user(null, $email, $password, \Gf\Auth\Users::$administrator, [
                'account_active' => 1,
                'email_verified' => 1,
            ], [
            ]);

            $session = \Gf\Auth\Auth::instance()->force_login($user_id);
            \Gf\Auth\SessionManager::instance()->create_snapshot($session, null, null, \Gf\Platform::$web);

            \Gf\Config::instance()->set([
                'ready' => 1,
            ])->save();

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
