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

}
