<?php
/**
 * Created by PhpStorm.
 * User: Boniface
 * Date: 5/26/2015
 * Time: 8:37 AM
 */

class Controller_Apilogincheck extends Fuel\Core\Controller{

    public function before(){
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