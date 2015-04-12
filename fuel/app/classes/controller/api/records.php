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
        $get = Input::get();
        
        $limit = isset($get['limit']) ? $get['limit'] : false;
        $offset = isset($get['offset']) ? $get['offset'] : false;
        
        $record = new Model_Record();
        $data = $record->get($id, $limit, $offset);

        foreach ($data as $k => $v) {
            $data[$k]['file_add'] = $this->newLine(unserialize($data[$k]['file_add']));
            $data[$k]['file_remove'] = $this->newLine(unserialize($data[$k]['file_remove']));
            $data[$k]['file_skip'] = $this->newLine(unserialize($data[$k]['file_skip']));
        }

        echo json_encode(array(
            'status' => true,
            'data' => $data,
            'count' => 
        ));
    }
    public function newLine($arg){
        if(count($arg) == 0){
            return $arg;
        }
        return $arg;
    }
}
