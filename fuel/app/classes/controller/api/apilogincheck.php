<?php

class Controller_Api_Apilogincheck extends Controller_Rest {
    public function before() {
        parent::before();
        if (!Auth::check()) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => '10001'
            ));
            die();
        }
    }
}