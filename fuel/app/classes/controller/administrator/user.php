<?php

class Controller_Administrator_User extends Controller_Administrator_Admincheck {
    public function action_index() {
        $users = DB::select()->from('users');
        if (Input::method() == 'POST')
            $users = $users->where($_POST['key'], $_POST['value']);

        $users = $users->execute()->as_array();
        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/user', array(
                'users' => $users,
                'key'   => (Input::method() == "POST") ? $_POST['key'] : '',
                'value' => (Input::method() == "POST") ? $_POST['value'] : '',
            ))
        ));
    }

    public function get_add() {
        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/useradd', array())
        ));
    }

    public function get_resetpassword($username) {
        $newpassword = \Auth::instance()->reset_password($username);
        $s = 'new password for user: ' . $username . '<br> ------ : ';
        $s .= $newpassword;

        echo View::forge('admin/base_layout', array(
            'data' => $s
        ));
    }

    public function post_add() {
        $i = Input::post();
        \Auth::instance()->create_user(
            $i['username'],
            $i['password'],
            $i['email'],
            $i['group']
        );
        Response::redirect('/administrator/user');
    }

    public function get_delete() {
        \Auth::instance()->delete_user($_GET['delete']);
        Response::redirect('/administrator/user');
    }
}
