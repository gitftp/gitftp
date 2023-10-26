<?php

use Gf\Auth\Auth;

class Controller_Console_Api_Auth extends Controller_Console_Authenticate {

    public function post_update_password () {
        try {
            $oldPassword = Input::json('old_password', false);
            $newPassword = Input::json('new_password', false);

            if (!$oldPassword or !$newPassword)
                throw new \Gf\Exception\UserException('Missing parameters');

            $users = \Gf\Auth\Users::instance();
            $hash = $users->hash_password($oldPassword);
            $user = $users->get_one([
                'id'       => $this->user_id,
                'password' => $hash,
            ]);

            if (!$user)
                throw new \Gf\Exception\UserException('The old password is wrong, try again');

            if ($oldPassword == $newPassword)
                throw new \Gf\Exception\UserException('The old and new passwords are the same');

            $users->update_user([
                'id' => $this->user_id,
            ], [
                'password' => $users->hash_password($newPassword),
            ]);

            $r = [
                'status' => true,
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

    public function get_logout () {
        try {
            Auth::instance()->logout();

            $r = [
                'status' => true,
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