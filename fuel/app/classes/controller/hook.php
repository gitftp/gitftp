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
        
        if()
            
    }
}
