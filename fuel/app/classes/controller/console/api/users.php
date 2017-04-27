<?php

use Fuel\Core\Input;

class Controller_Console_Api_Users extends Controller_Console_Authenticate {

    public function post_save_user () {
        try {
            $user = Input::json('user');
            $user_id = Input::json('user.id');

            $create_projects = Input::json('user.profile_fields.create_projects', false);
            $administrator = Input::json('user.profile_fields.administrator', false);
            $username = Input::json('user.username', false);
            $password = Input::json('user.password', false);
            $email = Input::json('user.email', false);

            if (!$username or !$email)
                throw new \Gf\Exception\UserException('Incomplete details, please try again.');

            if ($user_id) {
                $set = [];
                if ($password)
                    $set['password'] = $password;

                $set['email'] = $email;

                $existingGroup = \Gf\Auth\Users::instance()->get_one([
                    'id' => $user_id,
                ], [
                    'group',
                ]);
                if ($existingGroup and $existingGroup['group'] == \Gf\Auth\Users::$administrator) {
                    $create_projects = 1;
                    $administrator = 1;
                }

                \Gf\Auth\Users::instance()->update_user([
                    'id' => $user_id,
                ], $set, [
                    'create_projects' => (int)$create_projects,
                    'administrator'   => (int)$administrator,
                ]);
            } else {
                $set = [];
                if ($password)
                    $set['password'] = $password;

                $set['email'] = $email;
                $set['username'] = $username;
                $user_id = \Gf\Auth\Users::instance()->create_user($username, $email, $password, \Gf\Auth\Users::$member, [
                    'invite_pending'  => 1,
                    'account_active'  => 1,
                    'create_projects' => (int)$create_projects,
                    'administrator'   => (int)$administrator,
                ]);
            }


            $r = [
                'status' => true,
                'data'   => [
                    'user_id' => $user_id,
                ],
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    public function post_user () {
        try {
            $id = Input::json('id');
            $user = \Gf\Auth\Users::instance()->get_one([
                'id' => $id,
            ], [
                'created_at',
                'email',
                'group',
                'id',
                'username',
                'profile_fields',
            ]);

            if (!$user)
                throw new \Gf\Exception\UserException('The user does not exists');

            $user = \Gf\Auth\Users::instance()->parse($user);

            $r = [
                'status' => true,
                'data'   => $user,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    public function post_list () {
        try {
            $offset = Input::json('offset');
            $limit = Input::json('limit', 10);

            $users = \Gf\Auth\Users::instance();
            $usersList = $users->get([], [
                'created_at',
                'email',
                'group',
                'id',
                'last_login',
                'username',
                'profile_fields',
            ], $limit, $offset, true);
            $totalUsers = \Gf\Utils::sqlGetFoundRows();
            $usersList = \Gf\Auth\Users::instance()->parse($usersList);

            $r = [
                'status' => true,
                'data'   => [
                    'users' => $usersList,
                    'total' => $totalUsers,
                ],
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

}