<?php

class Controller_User extends Controller {
    /**
     * Page for user logout, redirects the user to respective homepage.
     */
    public function get_logout() {
        \Auth::instance()->logout();
        Response::redirect('/');
    }

    /**
     * Forgot password page.
     *
     * @return \Fuel\Core\View
     */
    public function action_forgotpassword() {
        if (\Auth::instance()->check()) {
            Response::redirect(dash_url);
        }

        if (Input::get('token')) {
            $key = Input::get('token');
            list($user_id, $key) = explode('-', $key);
            try {
                $user = new \Craftpip\OAuth\Auth($user_id);
                $key2 = $user->getAttr('forgotpassword_key');

                if ($key != $key2) {
                    throw new Exception();
                }

                $reset = TRUE;
            } catch (Exception $e) {
                $reset = FALSE;
            }
        }

        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/forgotpassword', array(
            'reset'   => (isset($reset)) ? $reset : FALSE,
            'user_id' => (isset($user_id)) ? $user_id : FALSE,
            'key'     => (isset($key2)) ? $key2 : FALSE,
        ));

        return $view;
    }

    /**
     * page for user login,
     * <homeurl>/login
     *
     * @return \Fuel\Core\View
     */
    public function action_login() {
        if (\Auth::instance()->check()) {
            Response::redirect(dash_url);
        }

        if (Input::get('verify')) {
            $key = Input::get('verify');
            list($user_id, $key) = explode('-', $key);
            try {
                $user = new \Craftpip\OAuth\Auth($user_id);
                $key2 = $user->getAttr('verify_key');

                if ($key != $key2) {
                    throw new Exception();
                }

                $user->removeAttr('verify_key');
                $user->setAttr('verified', 1);
                $verified = TRUE;
            } catch (Exception $e) {
                $verified = FALSE;
            }
        }

        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/login', array(
            'email_verification' => (isset($verified)) ? $verified : NULL,
        ));

        return $view;
    }

    /**
     * page for user Signup, // disabled for the moment.
     * <homeurl>/signup
     *
     * @return \Fuel\Core\View
     */
    public function action_signup() {
        if(\Auth::instance()->check())
            Response::redirect(dash_url);

        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->meta = View::forge('home/layout/meta');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/signup');

        return $view;
    }

    // not known
    public function action_signup2() {
        if (Input::method() != 'POST') {
            return FALSE;
        }

        $i = Input::post();

        $v = Validation::forge();
        $v->add('username', $i['username'])->add_rule('required');
        $v->add('password', $i['password'])->add_rule('required')->add_rule('min_length', 4);
        $v->add('fullname', $i['fullname'])->add_rule('required');
        $v->add('email', $i['email'])->add_rule('required')->add_rule('valid_email');
        $v->set_message('required', ':field is required');
        $v->set_message('valid_email', ':value is not a valid email.');

        if ($v->run()) {
            // username, password, email, group, extras
            try {
                $id = Auth::create_user($i['username'], $i['password'], $i['email'], 1, array(
                    'fullname'   => $i['fullname'],
                    'project_limit' => 2,
                    'verified'   => 0
                ));
            } catch (Exception $exc) {
                echo json_encode(array(
                    'status' => FALSE,
                    'reason' => $exc->getMessage()
                ));
                die();
            }


            echo json_encode(array(
                'status'   => TRUE,
                'redirect' => dash_url
            ));

        } else {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => 'The form seems to have missed something or has invalid data.',
                'fields' => array(
                    'username' => $v->error('username') ? $v->error('username')->get_message() : NULL,
                    'password' => $v->error('password') ? $v->error('password')->get_message() : NULL,
                    'fullname' => $v->error('fullname') ? $v->error('fullname')->get_message() : NULL,
                    'email'    => $v->error('email') ? $v->error('email')->get_message() : NULL,
                )
            ));
        }
    }
}
