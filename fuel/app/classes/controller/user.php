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

        if ($v->run()) {
            echo 'success';
        } else {
            echo json_encode(array(
                'status' => false,
                'reason' => 'Fields could not be validated',
                'fields' => array(
                    'username' => $v->error('username') ? $v->error('username')->get_message() : null,
                    'username' => $v->error('username') ? $v->error('username')->get_message() : null,
                    'username' => $v->error('username') ? $v->error('username')->get_message() : null,
                )
            ));
        }
        die();

        $id = Auth::create_user(
                        $i['username'], // username
                        $i['password'], //password 
                        $i['email'], //email
                        1, //group
                        array(//extras
                    'fullname' => $i['fullname'],
                        )
        );
    }

}
