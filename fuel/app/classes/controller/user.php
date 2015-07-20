<?php

class Controller_User extends Controller {

    public function action_index() {
        echo '';
    }

    public function action_logout() {
        Auth::logout();
        Response::redirect('/');
    }

    public function action_login() {
        $a = Input::post();

        if (Auth::validate_user($a['email'], $a['password'])) {
            Auth::login($a['email'], $a['password']);
            echo json_encode(array(
                'status'   => TRUE,
                'redirect' => dash_url,
            ));
        } else {
            echo json_encode(array(
                'status'   => FALSE,
                'redirect' => NULL,
                'reason'   => 'Your Email and Password do not match, please re-try again.'
            ));
        }
    }

    public function action_register() {
        Auth::create_user(
            'boniface',
            'thisissparta',
            'bonifacepereira@gmail.com',
            1,
            array(
                'fullname' => 'Boniface pereira',
            )
        );
    }

    public function action_signup() {
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

}
