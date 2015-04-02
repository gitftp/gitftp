<?php

class Controller_Api extends Controller {

    public function action_index() {
        
    }

    public function action_addftp() {
        if (!Auth::check()) {
            return false;
        }
        
        $data = Input::post();
        $user_id = Auth::get_user_id()[1];
        $data['user_id'] = $user_id;
        DB::insert('ftpdata')->set($data)->execute();
    }
    
    public function action_deleteftp(){
        
        if (!Auth::check()) {
            return false;
        }
        
        
        
    }
}
