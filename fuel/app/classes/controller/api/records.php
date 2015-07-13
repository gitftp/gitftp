<?php

class Controller_Api_Records extends Controller_Apilogincheck {

    public function action_index() {

    }

    public function action_get($id = NULL) {
        $get = Input::get();
        $limit = isset($get['limit']) ? $get['limit'] : FALSE;
        $offset = isset($get['offset']) ? $get['offset'] : FALSE;
        $record = new Model_Record();
        $data = $record->get($id, $limit, $offset);

        $branch = new Model_Branch();
        foreach ($data as $k => $v) {
            $data[$k]['branch'] = $branch->get_by_branch_id($v['branch_id']);
            $data[$k]['raw'] = (!empty($data[$k]['raw'])) ? TRUE : FALSE;
            $data[$k]['post_data'] = (!empty($data[$k]['post_data'])) ? TRUE : FALSE;
        }

        echo json_encode(array(
            'status' => TRUE,
            'data'   => $data,
            'count'  => $record->get_count($id)
        ));
    }

    public function action_getraw($record_id) {
        $record = new Model_Record();
        $record = $record->get_raw_by_record($record_id);
        $record = unserialize($record[0]['raw']);

        if (empty($record)) {
            echo '<p class="text-center" style="color: #aaa;font-size: 20px;">Sorry, no logs yet.</p>';
        } else {
            $string = '<i class="fa fa-wrench fa-fw"></i> Raw output data is presented for understanding errors in deployments, If you aren\'t sure why your deploy failed, please contact us.<br><code> --- <br>';
            $record_n = new RecursiveIteratorIterator(new RecursiveArrayIterator($record));
            foreach ($record_n as $k => $v) {
                $k = (is_numeric($k)) ? '' : $k.'-';
                $string .= "$ $k$v<br>";
            }
            echo "$string</code>";
        }

    }

    public function action_getpayload($record_id) {

        $record = new Model_Record();
        $record = $record->get_post_data_by_record($record_id);
        $record = $record[0]['post_data'];

        if (empty($record)) {
            echo '<p class="text-center" style="color: #aaa;font-size: 20px;">No payload found for given deploy.</p>';
        } else {
            echo '<pre>';
            echo json_encode(unserialize($record), JSON_PRETTY_PRINT);
            echo '</pre>';
        }

    }
}
