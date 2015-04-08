<?php

class Controller_Api_Ftp extends Controller {

    public function action_index() {
        
    }

    /**
     * List one or more FTP.
     * @param type $id
     * @return type
     */
    public function action_getall($id = null) {
        if (!Auth::check()) {
            echo json_encode(array(
                'status' => false,
                'reason' => 'Not logged in',
                'request' => Input::post()
            ));
            return;
        }
        
        $ftp = new Model_Ftp();
        $data = $ftp->get();
        
        echo json_encode(array(
            'status' => true,
            'data' => $data
        ));
    }

    /**
     * adding a FTP server.
     * @return boolean
     */
    public function action_addftp() {
        if (!Auth::check()) {

            echo json_encode(array(
                'status' => false,
                'reason' => 'Not logged in',
                'request' => Input::post()
            ));
            return;
            
        }

        $data = Input::post();
        $user_id = Auth::get_user_id()[1];
        $data['user_id'] = $user_id;

        $existing = DB::select()->from('ftpdata')
                        ->where('host', $data['host'])
                        ->and_where('username', $data['username'])
                        ->and_where('user_id', $user_id)
                        ->execute()->as_array();

        if (count($existing) > 0) {
            echo json_encode(array(
                'status' => false,
                'request' => Input::post(),
                'reason' => 'A FTP account with the same host and username already exist.'
            ));
        } else {
            $a = DB::insert('ftpdata')->set($data)->execute();
            if ($a) {
                echo json_encode(array(
                    'status' => true,
                    'request' => Input::post()
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
                'status' => false,
                'reason' => 'Not logged in',
                'request' => Input::post()
            ));
            return;
        }

        $row = DB::select()->from('ftpdata')
                        ->where('id', $id)
                        ->and_where('user_id', Auth::get_user_id()[1])
                        ->execute()->as_array();

        if (count($row) == 0) {
            echo json_encode(array(
                'status' => false,
                'request' => Input::post(),
                'reason' => 'You are not authorized to delete.'
            ));
        } else {

            $result = DB::delete('ftpdata')->where('id', $id)->execute();

            if ($result) {
                echo json_encode(array(
                    'status' => true,
                    'request' => Input::post()
                ));
            } else {
                echo json_encode(array(
                    'status' => false,
                    'request' => Input::post(),
                    'reason' => 'Cound not insert the value'
                ));
            }
        }
    }

}
