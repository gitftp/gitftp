<?php

use Gf\Auth\Auth;

class Controller_Console_Authenticate extends Controller_Rest {
    public $user_id = false;

    public function before () {
        parent::before();

        if (Auth::instance()->user_id) {
            $this->user_id = Auth::instance()->user_id;
        } else {
            // the user is not authenticated.
            \Fuel\Core\Response::redirect('/');
        }
    }
}
