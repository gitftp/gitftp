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
        if (Input::method() == 'POST') {
            $a = Input::post();
            if (Auth::validate_user($a['email'], $a['password'])) {
                Auth::login($a['email'], $a['password']);
                Response::redirect('/dashboard');
            } else {
                Response::redirect('/');
            }
        }
    }

    public function action_register() {
        Auth::create_user(
                'boniface', 'thisissparta', 'bonifacepereira@gmail.com', 1, array(
            'fullname' => 'Boniface pereira',
                )
        );
    }

}
