<?php

class Controller_Administrator_Admincheck extends Controller_Rest {
    public function before() {
        parent::before();
        if (!\Auth::instance()->check() && \Auth::instance()->get('group') !== 2) {
            Response::redirect(home_url . 'login#');
        }
    }
}