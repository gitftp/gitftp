<?php

class Controller_Setup_Start extends Controller_Hybrid {
    public $template = 'base_layout';

    public function get_index () {
        if (GF_CONFIG_FILE_EXISTS and \Gf\Config::instance()->get('ready', false)) {
            try {
                $administratorUser = \Gf\Auth\Users::instance()->get_one([
                    'group' => \Gf\Auth\Users::$administrator,
                ]);
                if ($administratorUser)
                    \Fuel\Core\Response::redirect('/');
            } catch (Exception $e) {
            }
        }

        $githubCallbackUrl = \Fuel\Core\Uri::create('oauth/authorize/github');
        $bitbucketCallbackUrl = \Fuel\Core\Uri::create('oauth/authorize/bitbucket');
        $baseUrl = \Fuel\Core\Uri::base();

        $this->template->body = \Fuel\Core\View::forge('setup/start', [
            'githubCallbackUrl'    => $githubCallbackUrl,
            'bitbucketCallbackUrl' => $bitbucketCallbackUrl,
            'baseUrl'              => $baseUrl,
        ]);
        $this->template->title = "Gitftp setup";
        $this->template->js = \Fuel\Core\View::forge('js');
        $this->template->css = \Fuel\Core\View::forge('css');
    }
}
