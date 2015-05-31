<?php

class Controller_Api_Records extends Controller_Apilogincheck {

    public function action_index() {
        
    }

    public function action_getall($id = null) {
        $get = Input::get();
        $limit = isset($get['limit']) ? $get['limit'] : false;
        $offset = isset($get['offset']) ? $get['offset'] : false;
        $record = new Model_Record();
        $data = $record->get($id, $limit, $offset);

        $branch = new Model_Branch();

        foreach($data as $k => $v){
            $data[$k]['branch'] = $branch->get_by_branch_id($v['branch_id']);
        }

        echo json_encode(array(
            'status' => true,
            'data' => $data,
            'count' => $record->get_count($id)
        ));
    }

    public function action_getraw($record_id) {

        $record = new Model_Record();
        $record = $record->get_raw_by_record($record_id);
        $record = unserialize($record[0]['raw']);
        $string = '<i class="fa fa-wrench fa-fw"></i> Raw output data is presented for understanding errors in deployments, If you aren\'t sure why your deploy failed, please contact us.<br><code> --- <br>';

        $record_n = new RecursiveIteratorIterator(new RecursiveArrayIterator($record));

        foreach ($record_n as $k => $v) {
            $string .= "[$k] - $v<br>";
        }

        if(empty($record)){
            echo 'Sorry, no logs yet.';
        }else{
            echo "$string</code>";
        }

    }

    public function action_getpayload($record_id){

        $record = new Model_Record();
        $record = $record->get_post_data_by_record($record_id);
        $record = $record[0]['post_data'];

        if(empty($record)){
            echo 'Sorry, no payload data found.';
        }else{
            echo '<pre>';
            print_r(unserialize($record));
            echo '</pre>';
        }

    }
}
