<?php

class Controller_Api_Records extends Controller_Api_Apilogincheck {

    public function get_get($deploy_id = NULL) {
        try {
            $i = Input::get();
            $limit = isset($i['limit']) ? $i['limit'] : FALSE;
            $offset = isset($i['offset']) ? $i['offset'] : FALSE;
            $record = new Model_Record();
            $data = $record->get($deploy_id, $limit, $offset);
            $branch = new Model_Branch();
            foreach ($data as $k => $v) {
                $data[$k]['branch'] = $branch->get_by_branch_id($v['branch_id']);
                $data[$k]['raw'] = (!empty($data[$k]['raw'])) ? TRUE : FALSE;
                $data[$k]['post_data'] = (!empty($data[$k]['post_data'])) ? TRUE : FALSE;
            }

            $this->response(array(
                'status' => TRUE,
                'data'   => $data,
                'count'  => $record->get_count($deploy_id),
            ));
        } catch (Exception $e) {
            $this->response(array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            ), $e->getCode());
        }
    }

    public function action_raw($record_id) {
        try {
            $record = new \Model_Record();
            $record = $record->get_raw_by_record($record_id);
            if (!count($record)) {
                throw new \Craftpip\Exception('Sorry, Record was not found.');
            }
            $record = unserialize($record[0]['raw']);
            if (empty($record)) {
                $data = '<p class="text-center" style="color: #aaa;font-size: 20px;">Sorry, no logs yet.</p>';
            } else {
                $string = '<i class="fa fa-wrench fa-fw"></i> Raw output data is presented for understanding deployments.<br><span class="mono" style="font-size: 12px"> --- <br>';
                $record_n = new RecursiveIteratorIterator(new RecursiveArrayIterator($record));
                foreach ($record_n as $k => $v) {
                    if($k === 'Failure'){
                        $k = (is_numeric($k)) ? '' : $k . ': ';
                        $string .= "<span class=\"red-bg\">$ $k$v</span><br>";
                    }else{
                        $k = (is_numeric($k)) ? '' : $k . ': ';
                        $string .= "$ $k$v<br>";
                    }

                }
                $string .= '</span>';
            }
            $response = array(
                'status' => TRUE,
                'data'   => $string,
            );
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);
    }

    public function action_payload($record_id) {
        try {
            $record = new Model_Record();
            $record = $record->get_post_data_by_record($record_id);
            $record = $record[0]['post_data'];

            if (empty($record)) {
                $data = '<p class="text-center" style="color: #aaa;font-size: 20px;">No payload found for given deploy.</p>';
            } else {
                $data = '<pre>';
                $data .= json_encode(unserialize($record), JSON_PRETTY_PRINT);
                $data .= '</pre>';
            }

            $this->response(array(
                'status' => TRUE,
                'data'   => $data,
            ), 200);

        } catch (Exception $e) {

            $this->response(array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            ), $e->getCode());
        }
    }
}
