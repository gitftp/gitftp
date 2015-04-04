<?php

class Controller_Api_Deploy extends Controller {

    public function action_index() {
        
    }

    public function action_getall($id = null) {

        if (!Auth::check()) {
            return false;
        }

        $user_id = Auth::get_user_id()[1];

        $a = DB::select()->from('deploy')->where('user_id', $user_id);

        if ($id != null) {
            $a = $a->and_where('id', $id);
        }

        $a = $a->execute()->as_array();


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

        $b = DB::select()->from('deploy')
                        ->where('name', $i['name'])
                        ->and_where('user_id', $user_id)
                        ->execute()->as_array();

        if (count($b) == 0) {

            $a = DB::insert('deploy')->set(array(
                        'repository' => $i['repo'],
                        'username' => $i['username'],
                        'name' => $i['name'],
                        'password' => $i['password'],
                        'user_id' => $user_id,
                        'ftp' => serialize($ftp),
                        'key' => $i['key'],
                        'cloned' => false,
                        'deployed' => false,
                        'lastdeploy' => false,
                        'status' => 'Not initialized',
                        'created_at' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp())
                    ))->execute();

            if ($a[1] !== 0) {
                echo json_encode(array(
                    'status' => true,
                    'request' => $i
                ));
            }
        } else {
            echo json_encode(array(
                'status' => false,
                'request' => $i,
                'reason' => 'A deploy with same name already exist'
            ));
        }
    }

    public function action_start($id = null) {

        if ($id == null || !Auth::check()) {
            return false;
            
        }
        
        $user_id = Auth::get_user_id()[1];
        $repohome = DOCROOT.'fuel/repository';
        $repo = DB::select()->from('deploy')->where('id', $id)->execute()->as_array();
        $repo = $repo[0];
                
        try{
            //check if users folder is made or not
            File::read_dir($repohome.'/'.$user_id);
        }catch(Exception $e){
            //make it 
            File::create_dir($repohome, $user_id, 0755);
        }
        
        $userdir = $repohome.'/'.$user_id;
        
        try {
            File::read_dir($userdir.'/'.$repo['name']);
        } catch (Exception $ex) {
            //create dir for repo
            File::create_dir($userdir, $repo['name'], 0755);
        }
        
        $repodir = $userdir.'/'.$repo['name'];
        
        $log = array();
        
        chdir($userdir);
        $cloning = shell_exec('git clone '.$repo['repository'].' '.$repo['name']);
        echo $cloning;
        // lets start
    }

}
