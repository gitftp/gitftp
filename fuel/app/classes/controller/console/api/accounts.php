<?php

use Fuel\Core\Input;
use Gf\Config;

class Controller_Console_Api_Accounts extends Controller_Console_Authenticate {

    public function post_list () {
        try {
            $list = [];
            if ($github = Config::instance()->get('github', false)) {
                $list['github'] = true;
            }
            if ($bitbucket = Config::instance()->get('bitbucket', false)) {
                $list['bitbucket'] = true;
            }

            $connected = \Gf\Auth\OAuth::getConnectedAccounts($this->user_id, [
                'id',
                'provider',
                'username',
                'created_at',
                'updated_at',
            ]);

            $r = [
                'status' => true,
                'data'   => [
                    'connected' => $connected,
                    'providers' => $list,
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

}
