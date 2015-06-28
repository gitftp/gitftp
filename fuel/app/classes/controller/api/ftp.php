<?php

class Controller_Api_Ftp extends Controller_Apilogincheck {

    public function action_index() {

    }

    /**
     * List one or more FTP.
     * @param type $id
     * @return type
     */
    public function action_getall($id = NULL) {

        $ftp = new Model_Ftp();
        $data = $ftp->get($id);

        $data = utils::strip_passwords($data);

        echo json_encode(array(
            'status' => TRUE,
            'data'   => $data
        ));
    }

    public function post_testftp($a = null) {
        $i = Input::post();
        try {

            $options = array(
                'user'   => $i['username'],
                'host'   => $i['host'],
                'pass'   => $i['pass'],
                'scheme' => $i['scheme'],
                'port'   => $i['port'],
                'path'   => $i['path'],
            );

            if (empty($i['pass']) && isset($i['id'])) {
                /*
                 * password is not set, lets check if its there with us.
                 */
                $ftp_id = $i['id'];
                $ftp_model = new Model_Ftp();
                $ftp_data = $ftp_model->get($ftp_id);
                if (count($ftp_data) !== 1) {
                    throw new Exception('Ftp does not exist, or has been deleted.');
                }
                $ftp_data = $ftp_data[0];
                if (!empty($ftp_data['pass'])) {
                    $options['pass'] = $ftp_data['pass'];
                }
            }

            $ftp_url = http_build_url($options);
            if(utils::test_ftp($ftp_url)){
                echo json_encode(array(
                    'status' => TRUE
                ));
            }else{
                throw new Exception('Could not connect');
            }

        } catch (Exception $e) {
            echo json_encode([
                'status' => FALSE,
                'reason' => $e->getMessage()
            ]);
            return false;
        }
        return true;
    }

    /**
     * adding a FTP server.
     * @return boolean
     */
    public function post_addftp() {
        $this->post_testftp();
        $ftp = new Model_Ftp();
        $data = Input::post();
        $user_id = Auth::get_user_id()[1];

        $existing = DB::select()->from('ftpdata')->where('host', $data['host'])->and_where('username', $data['username'])->and_where('user_id', $user_id)->and_where('path', $data['path'])->execute()->as_array();

        if (count($existing) > 0) {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => Input::post(),
                'reason'  => 'A FTP account with the same host and username already exist.'
            ));
        } else {

            $a = $ftp->insert($data);
            if ($a) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post()
                ));
            }
        }
    }
    // todo: no output for testftp conditional.
    /**
     * editing a FTP server.
     * @return boolean
     */
    public function post_editftp($id) {
        if(!$this->post_testftp()){
            return false;
        }

        try{

            $ftp = new Model_Ftp();
            $data = Input::post();
            $user_id = Auth::get_user_id()[1];

            $a = $ftp->set($id, $data);

            if ($a || false) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post(),
                ));
            } else {
                echo json_encode(array(
                    'status'  => FALSE,
                    'reason'  => 'Cannot update with the same values.',
                    'asd' => $a
                ));
            }

        }catch(Exception $e){

            echo json_encode(array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $id
            ));
        }

    }

    /**
     * Delete a FTP server by ID
     * @param type $id
     * @return type
     */
    public function action_delftp($id) {

        if (!Auth::check()) {
            echo json_encode(array(
                'status'  => FALSE,
                'reason'  => 'GT-405',
                'request' => Input::post()
            ));

            return;
        }

        $row = DB::select()->from('ftpdata')->where('id', $id)->and_where('user_id', Auth::get_user_id()[1])->execute()->as_array();

        if (count($row) == 0) {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => Input::post(),
                'reason'  => 'You are not authorized to delete.'
            ));
        } else {

            $result = DB::delete('ftpdata')->where('id', $id)->execute();

            if ($result) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post()
                ));
            } else {
                echo json_encode(array(
                    'status'  => FALSE,
                    'request' => Input::post(),
                    'reason'  => 'Cound not insert the value'
                ));
            }
        }
    }

}
