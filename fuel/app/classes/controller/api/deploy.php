<?php

class Controller_Api_Deploy extends Controller {

    public function action_index() {
        
    }

    public function action_getall() {

        if (!Auth::check()) {
            return false;
        }

        $user_id = Auth::get_user_id()[1];
        $a = DB::select()->from('deploy')->where('user_id', $user_id)
                        ->execute()->as_array();

        foreach ($a as $k => $v) {
            $ub = unserialize($v['ftp']);
            $c = DB::select()->from('ftpdata')->where('id', $ub['production'])->execute()->as_array();
            $a[$k]['ftp'] = $c;
        }

        echo json_encode(array(
            'status' => true,
            'data' => $a
        ));
    }

    public function action_delete($id = null) {
        if (!Auth::check()) {
            return false;
        }

        $user_id = Auth::get_user_id()[1];

        $b = DB::select()->from('deploy')->where('id', $id)->and_where('user_id', $user_id)
                        ->execute()->as_array();

        if (count($b) != 0) {
            
            DB::delete('deploy')->where('id', $id)->execute();
            echo json_encode(array(
                'status' => true,
                'request' => $id,
            ));
            
        } else {
            echo json_encode(array(
                'status' => false,
                'request' => $id,
                'reason' => 'No access'
            ));
        }
    }

    public function action_new() {
        if (!Auth::check()) {
            return false;
        }

        $i = Input::post();
        $user_id = Auth::get_user_id()[1];

        $ftp = array(
            'production' => $i['ftp-production']
        );

        $a = DB::insert('deploy')->set(array(
                    'repository' => $i['repo'],
                    'username' => $i['username'],
                    'password' => $i['password'],
                    'user_id' => $user_id,
                    'ftp' => serialize($ftp),
                    'key' => $i['key']
                ))->execute();

        if ($a[1] !== 0) {
            echo json_encode(array(
                'status' => true,
                'request' => $i
            ));
        }
    }

}
