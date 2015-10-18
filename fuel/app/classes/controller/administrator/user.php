<?php

class Controller_Administrator_User extends Controller_Administrator_Admincheck {
    public function action_index() {
        $users = DB::select()->from('users');

        if (isset($_GET['value'])) {
            $value = $_GET['value'];
            $users = $users
                ->where('username', 'like', $value)
                ->or_where('email', 'like', $value)
                ->or_where('id', 'like', $value)
                ->or_where('group', 'like', $value);
        }

        $users = $users->order_by('id', 'DESC');

        $users = $users
            ->execute()
            ->as_array();

        foreach ($users as $k => $v) {
            $user = new \Craftpip\OAuth\Auth($v['id']);
            $users[$k]['verified'] = $user->getAttr('verified');
            $users[$k]['repol'] = $user->getAttr('project_limit');
        }

        echo \View::forge('admin/base_layout', array(
            'data' => \View::forge('admin/user', array(
                'users' => $users,
                'value' => \Input::get('value', ''),
//                'pagination' => $pagination
            ))
        ));
    }

    public function get_add() {
        echo View::forge('admin/base_layout', array(
            'data' => View::forge('admin/useradd', array())
        ));
    }

    public function get_edituser($user_id) {
        $user = new \Craftpip\OAuth\Auth($user_id);
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
        $user = new \Craftpip\OAuth\Auth($user_id);
        $user->setAttr('verified', \Input::post('verified', FALSE));
        $user->setAttr('project_limit', \Input::post('project_limit', 0));

        Response::redirect('/administrator/user');
    }

    public function get_resetpassword($username) {
        $newpassword = \Auth::instance()->reset_password($username);
        echo $newpassword;
    }

    public function post_add() {
        $i = Input::post();

        $user = new \Craftpip\OAuth\Auth();

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

//    public function get_delete($username) {
//        $data = \DB::select()->from('users')->where('username', $username)->execute();
//        $userid = $data[0]['id'];
//        \Auth::instance()->delete_user($username);
//        \DB::delete('users_providers')->where('parent_id', $userid)->execute();
//        echo 'OK';
//    }
}
