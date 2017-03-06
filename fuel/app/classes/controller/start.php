<?php

use Gf\Auth\Auth;

class Controller_Start extends Controller {
    public function get_index () {
        $isReady = \Gf\Config::instance()->get('ready', false);
        if (!$isReady or !GF_CONFIG_FILE_EXISTS)
            Response::redirect('setup/start');

        if (Auth::instance()->user_id) {
            $user = Auth::instance()->user;
            $user = \Gf\Auth\Users::instance()->parse($user);

            return \Fuel\Core\View::forge('panel/base_layout', [
                'js'   => \Fuel\Core\View::forge('js'),
                'css'  => \Fuel\Core\View::forge('css'),
                'user' => $user,
            ]);
        } else {
            \Fuel\Core\Response::redirect('login');
        }
    }
}
