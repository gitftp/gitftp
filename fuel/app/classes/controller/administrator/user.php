<?php

class Controller_Administrator_User extends Controller_Administrator_Admincheck {
    public function action_index() {
        $users = DB::select()->from('users');

        if (isset($_GET['key']))
            $users = $users->where($_GET['key'], $_GET['value']);

        $users = $users->execute()->as_array();

        foreach ($users as $k => $v) {
            $user = new \Craftpip\Auth($v['id']);
            $users[$k]['verified'] = $user->getAttr('verified');
            $users[$k]['repol'] = $user->getAttr('project_limit');
        }

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

    public function get_edituser($user_id) {
        $user = new \Craftpip\Auth($user_id);
        $rl = $user->getAttr('project_limit');
        $v = $user->getAttr('verified');

        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/useredit', array(
                    'project_limit' => $rl,
                    'verified'      => $v
                )
            )
        ));
    }

    public function post_edituser($user_id) {
        $user = new \Craftpip\Auth($user_id);
        $user->setAttr('verified', Input::post('verified'));
        $user->setAttr('project_limit', Input::post('project_limit'));

        Response::redirect('/administrator/user');
    }

    public function get_resetpassword($username) {
        $newpassword = \Auth::instance()->reset_password($username);
        echo $newpassword;
    }

    public function post_add() {
        $i = Input::post();

        $user = new \Craftpip\Auth();

        $id = $user->create_user(
            $i['username'],
            $i['password'],
            $i['email'],
            $i['group'],
            array()
        );

        $user->setId($id);
        $user->setAttr('verified', (Bool)$i['verified']);
        $user->setAttr('project_limit', (int)$i['project_limit']);

        $mail = new \Craftpip\Mail($id);
        if ($i['sendemail'] !== 'no') {
            $mail->template_new_user_invite();
            $mail->send();
        }

        Response::redirect('/administrator/user');
    }

    public function get_delete($user_id) {
        \Auth::instance()->delete_user($user_id);
        echo 'OK';
    }
}
