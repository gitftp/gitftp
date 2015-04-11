<?php

class Controller_Api_Records extends Controller {

    public function action_index() {
        
    }

    public function action_getall($id = null) {
        if (!Auth::check()) {
            echo json_encode(array(
                'status' => false,
                'reason' => 'GT-405'
            ));
            return;
        }

        $record = new Model_Record();
        $data = $record->get($id);

        foreach ($data as $k => $v) {
            $data[$k]['file_add'] = unserialize($data[$k]['file_add']);
            $data[$k]['file_remove'] = unserialize($data[$k]['file_remove']);
            $data[$k]['file_skip'] = unserialize($data[$k]['file_skip']);
        }

        echo json_encode(array(
            'status' => true,
            'data' => $data
        ));
    }
    public function newLine($arg){
        
    }
}
