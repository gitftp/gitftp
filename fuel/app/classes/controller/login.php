<?php

use Fuel\Core\View;

class Controller_Login extends Controller {


    public function get_index () {
        $template = View::forge('base_layout');
        $template->js = View::forge('js');
        $template->css = View::forge('css');
        $template->title = 'Login to your gitftp account';
        $template->body = View::forge('login', []);

        return $template;
    }

    public function post_index () {
        try {
            $email = \Fuel\Core\Input::json('email', false);
            $password = \Fuel\Core\Input::json('password', false);

            if (!$email or !$password)
                throw new \Gf\Exception\UserException('Username and password are required');

            $auth = \Gf\Auth\Auth::instance();
            $session = $auth->login($email, $password);
            \Gf\Auth\SessionManager::instance()->create_snapshot($session, null, null, \Gf\Platform::$web);

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

        echo json_encode($r);
    }
}
