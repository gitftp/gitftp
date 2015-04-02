<?php

class Controller_Api_Ftp extends Controller {

    public function action_index() {
        
    }

    public function action_getall() {

        if (!Auth::check()) {
            echo json_encode(array(
                'status' => false,
                'reason' => 'Not logged in'
            ));
            return;
        }

        $user_id = Auth::get_user_id()[1];
        $data = DB::select()->from('ftpdata')->where('user_id', $user_id)->execute()->as_array();
        echo json_encode(array(
            'status' => true,
            'data' => $data
        ));
    }

    public function action_addftp() {
        if (!Auth::check()) {
            return false;
        }

        $data = Input::post();
        $user_id = Auth::get_user_id()[1];
        $data['user_id'] = $user_id;
        $a = DB::insert('ftpdata')->set($data)->execute();
        if ($a) {
            echo json_encode(array(
                'status' => true
            ));
        }
    }

    public function action_delftp($id) {

        if (!Auth::check()) {
            echo json_encode(array(
                'status' => false,
                'reason' => 'Not logged in'
            ));
            return;
        }

        $result = DB::delete('ftpdata')->where('id', $id)->execute();

        if ($result) {
            echo json_encode(array(
                'status' => true
            ));
        } else {
            echo json_encode(array(
                'status' => false
            ));
        }
    }

}
