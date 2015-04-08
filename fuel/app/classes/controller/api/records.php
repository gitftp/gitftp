<?php

class Controller_Api_Records extends Controller {

    public function action_index() {
        
    }

    public function action_getall($id = null) {
        if (!Auth::check()) {
            return false;
        }
        
        $record = new Model_Record();
        $data = $record->get($id);
        
        echo json_encode(array(
            'status' => true,
            'data' => $data
        ));
    }


}
