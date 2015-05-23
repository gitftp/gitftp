<?php

class Controller_Api_Records extends Controller {

    public function action_index() {
        
    }

    public static function _init() {
        if (!Auth::check()) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => 'GT-405'
            ));
            die();
        }
    }
    public function action_getall($id = null) {
        $get = Input::get();
        $limit = isset($get['limit']) ? $get['limit'] : false;
        $offset = isset($get['offset']) ? $get['offset'] : false;
        $record = new Model_Record();
        $data = $record->get($id, $limit, $offset);

        echo json_encode(array(
            'status' => true,
            'data' => $data,
            'count' => $record->get_count($id)
        ));
    }

    public function action_getraw($id) {

        $record = new Model_Record();
        $record = $record->get_raw_by_record($id);
        echo '<pre>';
        print_r(unserialize($record[0]['raw']));
        echo '</pre>';

    }
}
