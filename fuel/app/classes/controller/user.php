<?php

class Controller_User extends Controller {

    public function action_index() {
        echo '';
    }

    public function action_logout() {
        Auth::logout();
        Response::redirect('/');
    }

    public function action_check_json() {
        echo json_encode(array(
            'status' => true,
            'data' => array(
                'id' => Auth::get_user_id()[1]
            ),
        ));
    }

    public function action_login() {
        $a = Input::post();

        if (Auth::validate_user($a['email'], $a['password'])) {
            Auth::login($a['email'], $a['password']);
            echo json_encode(array(
                'status' => true,
                'redirect' => dash_url,
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'redirect' => null,
                'reason' => 'Your Email and Password do not match, please re-try again.'
            ));
        }
    }

    public function action_register() {
        Auth::create_user(
                'boniface', 'thisissparta', 'bonifacepereira@gmail.com', 1, array(
            'fullname' => 'Boniface pereira',
                )
        );
    }

    public function action_signup() {
        if (Input::method() != 'POST') {
            return false;
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
                            'fullname' => $i['fullname'],
                            'repo_limit' => 2,
                            'verified' => 0
                ));
            } catch (Exception $exc) {
                echo json_encode(array(
                    'status' => false,
                    'reason' => $exc->getMessage()
                ));
                die();
            }

            
            echo json_encode(array(
                'status' => true,
                'redirect' => dash_url
            ));
            
        } else {
            echo json_encode(array(
                'status' => false,
                'reason' => 'The form seems to have missed something or has invalid data.',
                'fields' => array(
                    'username' => $v->error('username') ? $v->error('username')->get_message() : null,
                    'password' => $v->error('password') ? $v->error('password')->get_message() : null,
                    'fullname' => $v->error('fullname') ? $v->error('fullname')->get_message() : null,
                    'email' => $v->error('email') ? $v->error('email')->get_message() : null,
                )
            ));
        }
    }

}
