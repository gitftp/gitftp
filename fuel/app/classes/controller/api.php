<?php

class Controller_Api extends Controller {

    public function action_index() {
        
    }
    
    public function action_mail(){
        print_r(Input::post());
    }
    
}
