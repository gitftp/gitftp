<?php

class Controller_Hook extends Controller {

    public function action_index() {
        echo '';
    }

    public function action_i($user_id = null, $deploy_id = null, $key = null) {

        if ($user_id == null || $deploy_id == null || $key == null || Input::method() != 'POST') {
            die('Something is missing');
        }

        $check = DB::select('key')->from('deploy')->where('id', $deploy_id)->and_where('user_id', $user_id)
                ->execute()->as_array();
        
        if(count($check) == 0){
            die('No such user or deploy found.');
        }else{
            if($key != $check[0]['key']){
                die('The key provided doesnt match');
            }
        }

        $i = $_REQUEST['payload'];
        
        
//        $record = new Model_Record();
//        $record_id = $record->insert(array(
//            'deploy_id' => $deploy_id,
//            'user_id' => $user_id,
//            'status' => 2,
//            'date' => time(),
//            'triggerby' => $i[''],
//            'post_data' => serialize($i),
//        ));

        DB::insert('test')->set(array(
            'test' => serialize($_REQUEST['payload'])
        ))->execute();
    }

    public function action_get() {
        echo '<pre>';
        $a = DB::select()->from('test')->execute()->as_array();
        print_r(json_decode(unserialize($a[1]['test'])));
    }

}
