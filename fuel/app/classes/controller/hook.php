<?php

class Controller_Hook extends Controller {

    public function action_index() {
        echo '';
    }
    
    public function action_i($user_id = null, $deploy_id = null, $key = null){
        
        if($user_id == null || $deploy_id == null || $key == null){
            echo '404 brother';
            return ;
        }
        
        DB::insert('test')->set(array(
            'test' => serialize(Input::post())
        ));
//        if(Input::method() != 'POST'){
//            
//        }
    }
    
    public function action_get(){
        
    }
}
