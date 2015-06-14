<?php

class Controller_Api_Branch extends Controller_Apilogincheck {

    public function action_index() {
        echo '404';
    }

    public function post_updatebranch() {
        try {

            $i = Input::post();
            $dataToSave = array();
            $branch = new Model_Branch();
            $branch_data = $branch->get_by_branch_id($i['branch_id'], array('ftp_id'));
            $id = $i['branch_id'];

            if (count($branch_data) !== 1) {
                throw new Exception('The branch does not exist.');
            }

            if (isset($i['name']) && !empty($i['name'])) {
                $dataToSave['name'] = $i['name'];
            }

            if (isset($i['ftp_id']) && !empty($i['ftp_id'])) {
                if ($i['ftp_id'] !== $branch_data[0]['ftp_id']) {
                    $dataToSave['ftp_id'] = $i['ftp_id'];
                    $dataToSave['ready'] = FALSE;
                    $message = '<code>FTP server has been changed, please re-deploy the files to the new server.</code>';
                }
            }

            $dataToSave['auto'] = (isset($i['auto'])) ? TRUE : FALSE;

            $result = $branch->set($id, $dataToSave);
            if ($result) {
                $response = json_encode(array('status' => TRUE, 'message' => (isset($message)) ? $message : ''));
            } else {
                $response = json_encode(array('status' => FALSE, 'reason' => 'No changes were made.'));
            }
        } catch (Exception $e) {
            $response = json_encode(array('status' => FALSE, 'reason' => $e->getMessage()));
        }

        return $response;
    }

}
