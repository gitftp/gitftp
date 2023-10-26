<?php

use Fuel\Core\Controller_Rest;
use Fuel\Core\Input;

class Controller_Setup_Api extends Controller_Rest {
    /**
     * Do a dependency test
     */
    public function post_dep_test () {
        try {
            // @todo: check for ftp_secure and pthreads (optional)
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
    public function post_db_save () {
        try {
            $host = Input::json('db.host');
            $username = Input::json('db.username');
            $password = Input::json('db.password');
            $db_name = Input::json('db.dbname');
            // ready. install the schema to database here.
            \Gf\Misc::testDatabase($host, $db_name, $username, $password, '3307');

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
     * Test in incoming database config and set it in the configs
     */
    public function post_db_install () {
        try {
            if (!GF_CONFIG_FILE_EXISTS)
                throw new \Gf\Exception\UserException('Please refresh and try again');

            $host = \Gf\Config::instance()->get('mysql.host', false);
            if (!$host)
                throw new \Gf\Exception\UserException('This was not suppose to happen, please delete the .config.json file and try again.');

            \Fuel\Core\Migrate::latest('default', 'app', true);

            \Gf\Config::instance()->set([
                'dbInstalled' => true,
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
            $github = Input::json('providers.github', false);
            $bitbucket = Input::json('providers.bitbucket', false);

            if (!$github and !$bitbucket)
                throw new \Gf\Exception\UserException('Please configure at least one provider');

            if ($github and (!$github['clientId'] or !$github['clientSecret'])) {
                throw new \Gf\Exception\UserException('Incomplete github configuration');
            }

            if ($bitbucket and (!$bitbucket['clientId'] or !$bitbucket['clientSecret'])) {
                throw new \Gf\Exception\UserException('Incomplete bitbucket configuration');
            }

            $set = [];

            if ($github) {
                $set['github.clientId'] = $github['clientId'];
                $set['github.clientSecret'] = $github['clientSecret'];
            }
            if ($bitbucket) {
                $set['bitbucket.clientId'] = $bitbucket['clientId'];
                $set['bitbucket.clientSecret'] = $bitbucket['clientSecret'];
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
                'account_active'  => 1,
                'administrator'   => 1,
                'create_projects' => 1,
            ]);

            $session = \Gf\Auth\Auth::instance()->force_login($user_id);
            \Gf\Auth\SessionManager::instance()->create_snapshot($session, null, null, \Gf\Platform::$web);

            $baseUrl = \Fuel\Core\Uri::base(false);

            \Gf\Config::instance()->set([
                'ready'    => 1,
                'base_url' => $baseUrl,
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
