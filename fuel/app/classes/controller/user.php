<?php

class Controller_User extends Controller_Homepage {

    public function get_logout() {
        \Auth::instance()->logout();
        Response::redirect('/');
    }

    public function action_login() {
        if (\Auth::instance()->check()) {
            Response::redirect(dash_url);
        }

        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/login');

        return $view;
    }

    public function action_signup() {
        $view = View::forge('home/base_layout.mustache');
        $view->css = View::forge('home/layout/css');
        $view->js = View::forge('home/layout/js');
        $view->header = View::forge('home/layout/header');
        $view->footer = View::forge('home/layout/footer');
        $view->body = View::forge('home/signup');

        return $view;
    }

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
                    'repo_limit' => 2,
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

    public function action_test() {
        $user = new Model_User();
        echo '<pre>';
        echo $user->getProperty('created_at');
    }

    public function action_callback() {
        // Opauth can throw all kinds of nasty bits, so be prepared
        try {
            // get the Opauth object
            $opauth = \Auth_Opauth::forge(FALSE);
            echo '<pre>';
            // and process the callback
            $status = $opauth->login_or_register();
            print_r($opauth);
            print_r($status);
            die();
            // fetch the provider name from the opauth response so we can display a message
            $provider = $opauth->get('auth.provider', '?');

            // deal with the result of the callback process
            switch ($status) {
                // a local user was logged-in, the provider has been linked to this user
                case 'linked':
                    // inform the user the link was succesfully made

                    echo sprintf(__('login.provider-linked'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                // the provider was known and linked, the linked account as logged-in
                case 'logged_in':
                    // inform the user the login using the provider was succesful
                    echo sprintf(__('login.logged_in_using_provider'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                // we don't know this provider login, ask the user to create a local account first
                case 'register':
                    // inform the user the login using the provider was succesful, but we need a local account to continue
                    echo sprintf(__('login.register-first'), ucfirst($provider));
                    // and set the redirect url for this status
                    $url = 'user/register';
                    break;

                // we didn't know this provider login, but enough info was returned to auto-register the user
                case 'registered':
                    // inform the user the login using the provider was succesful, and we created a local account
                    echo __('login.auto-registered');
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                default:
                    throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
            }

            // redirect to the url set
            \Response::redirect($url);
        } // deal with Opauth exceptions
        catch (\OpauthException $e) {
            echo $e->getMessage();
//            \Response::redirect_back();
        } // catch a user cancelling the authentication attempt (some providers allow that)
        catch (\OpauthCancelException $e) {
            // you should probably do something a bit more clean here...
            exit('It looks like you canceled your authorisation.' . \Html::anchor('users/oath/' . $provider, 'Click here') . ' to try again.');
        }

    }

    public function action_oauth($provider = NULL) {
        // load Opauth, it will load the provider strategy and redirect to the provider
        \Auth_Opauth::forge();
    }

    public function action_register() {
        echo '<pre>';
        $opauth = \Auth_Opauth::forge(FALSE);
        print_r($opauth);
    }
}
