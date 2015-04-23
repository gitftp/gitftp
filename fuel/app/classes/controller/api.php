<?php

class Controller_Api extends Controller {

    public function action_index() {
        
    }
    
    public function action_mail(){
        echo '<pre>';
        print_r(Input::post());
    }
    
}
