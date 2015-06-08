<?php

class Controller_Api_Ftp extends Controller_Apilogincheck {

    public function action_index() {

    }

    /**
     * List one or more FTP.
     * @param type $id
     * @return type
     */
    public function action_getall($id = null) {

        $ftp = new Model_Ftp();
        $data = $ftp->get($id);

        $data = utils::strip_passwords($data);

        echo json_encode(array(
            'status' => TRUE,
            'data'   => $data
        ));
    }

    public function post_testftp() {
        $a = utils::test_ftp(Input::post());
        if ($a == 'Ftp server is ready to rock.') {
            echo json_encode(array(
                'status' => TRUE
            ));
        } else {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => $a
            ));
        }
    }

    /**
     * adding a FTP server.
     * @return boolean
     */
    public function action_addftp() {

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

    /**
     * editing a FTP server.
     * @return boolean
     */
    public function action_editftp($id) {
        if (!Auth::check()) {
            echo json_encode(array(
                'status'  => FALSE,
                'reason'  => 'GT-405',
                'request' => Input::post()
            ));

            return;
        }

        $ftp = new Model_Ftp();
        $data = Input::post();
        $user_id = Auth::get_user_id()[1];

        //        $existing = DB::select()->from('ftpdata')
        //                        ->where('host', $data['host'])
        //                        ->and_where('username', $data['username'])
        //                        ->and_where('user_id', $user_id)
        //                        ->and_where('path', $data['path'])
        //                        ->execute()->as_array();

        if (FALSE) {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => Input::post(),
                'reason'  => 'A FTP account with the same host and username already exist OR you didnt change anything ?.'
            ));
        } else {
            $a = $ftp->set($id, $data);

            if ($a || TRUE) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => Input::post()
                ));
            } else {
                echo json_encode(array(
                    'status'  => FALSE,
                    'reason'  => 'Cannot update with the same values.',
                    'request' => $id
                ));
            }
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
