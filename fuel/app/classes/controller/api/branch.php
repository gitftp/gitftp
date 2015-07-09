<?php

class Controller_Api_Branch extends Controller_Apilogincheck {

    public function action_index() {
        echo '404';
    }

    /**
     * Create single branch for given deploy.
     *
     * Sample post data:
     *   name: somename
     *   branch_name:HEAD
     *   ftp_id:130
     *   deploy_id:24
     */
    public function post_create() {
        try {
            $i = Input::post();

            // check if owner of this deploy.
            $deploy = new Model_Deploy();
            $branch = new Model_Branch();
            $deploy_data = $deploy->get($i['deploy_id']);

            if (count($deploy_data) !== 1) {
                throw new Exception('Something went wrong.');
            }

            $branch_data = $branch->get_by_ftp_id($i['ftp_id']);

            foreach ($branch_data as $b) {
                if ($b['branch_name'] == $i['branch_name'] && $b['deploy_id'] == $i['deploy_id'])
                    throw new Exception('An Environment named "'.$b['name'].'" already has the same Branch and FTP configured.');
            }

            $createData = array();
            $createData['name'] = $i['name'];
            $createData['branch_name'] = $i['branch_name'];
            $createData['ftp_id'] = $i['ftp_id'];
            $createData['deploy_id'] = $i['deploy_id'];
            if (isset($i['auto'])) {
                $createData['auto'] = TRUE;
            }

            $a = $branch->create($createData);

            if ($a[1] !== 1) {
                throw new Exception('We faced some problem while adding the environment. please try again later.');
            }

            $response = json_encode(array('status' => TRUE));
        } catch (Exception $e) {
            $response = json_encode(array('status' => FALSE, 'reason' => $e->getMessage()));
        }
        echo $response;
    }

    public function post_updatebranch() {
        try {
            $i = Input::post();
            $i = utils::escapeHtmlChars($i);

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
                    $message = '<i class="fa fa-info fa-fw blue red"></i> You\'ve successfully Re-linked a new FTP server.';
                    $dataToSave['revision'] = '';
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
