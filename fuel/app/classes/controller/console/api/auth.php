<?php

use Gf\Auth\Auth;

class Controller_Console_Api_Auth extends Controller_Console_Authenticate {
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