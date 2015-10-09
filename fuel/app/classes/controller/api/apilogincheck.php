<?php

class Controller_Api_Apilogincheck extends Controller_Rest {
    public function before() {
        parent::before();
        if (!\Auth::instance()->check()) {
            echo $this->response(array(
                'status' => FALSE,
                'reason' => '10001'
            ));
            die;
        }
    }
}