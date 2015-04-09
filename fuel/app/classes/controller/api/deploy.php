<?php

class Controller_Api_Deploy extends Controller {

    public function action_index() {
        
    }

    public function action_getall($id = null) {

        if (!Auth::check()) {
            return false;
        }

        $user_id = Auth::get_user_id()[1];
        $deploy = new Model_Deploy();

        $a = $deploy->get($id);

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

        $status = strtolower($b[0]['status']);

        if ($status == 'idle' || $status == 'not initialized') {

            $user_dir = DOCROOT . 'fuel/repository/' . $user_id;
            $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $b[0]['name'];
            chdir($repo_dir);
            echo shell_exec('chown www-data * -R');
            echo shell_exec('chgrp www-data * -R');
            echo shell_exec('chmod 777 -R');

//            echo shell_exec('rm .git/ -R -v');
//            echo shell_exec('rm * -R -v');
//            chdir($user_dir);
//            
//            echo shell_exec('rmdir ' . $b[0]['name'] . '/ -v');

            File::delete_dir($repo_dir, true, true);

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
        } else {
            return json_encode(array(
                'status' => false,
                'reason' => 'deploy busy, unable to delete in between of work',
                'request' => $id
            ));
        }
    }

    public function action_new() {
        if (!Auth::check()) {
            return false;
        }

        $i = Input::post();
        $user_id = Auth::get_user_id()[1];


        /*
         * FTP setup,
         * initial revision to empty.
         */
        $ftp = array(
            'production' => $i['ftp-production'],
            'revision' => ''
        );

        $a = DB::insert('deploy')->set(array(
                    'repository' => $i['repo'],
                    'username' => ($i['username']) ? $i['username'] : '',
                    'name' => $i['name'],
                    'password' => ($i['password']) ? $i['password'] : '',
                    'user_id' => $user_id,
                    'ftp' => serialize($ftp),
                    'key' => $i['key'],
                    'cloned' => false,
                    'deployed' => false,
                    'lastdeploy' => false,
                    'status' => 'to be initialized',
                    'ready' => false,
                    'created_at' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp())
                ))->execute();

        if ($a[1] !== 0) {
            echo json_encode(array(
                'status' => true,
                'request' => $i
            ));
        }
    }

    public function action_edit($id) {
        if (!Auth::check()) {
            return false;
        }

        $i = Input::post();
        $user_id = Auth::get_user_id()[1];
        
        /*
         * FTP setup,
         * initial revision to empty.
         */
        
        print_r($i);
        
        $a = DB::select()->from('deploy')->where('id', $id)->execute()->as_array();
        if($a[0]['user_id'] == $user_id){
            
            $a['ftp']
            
            DB::update('deploy')->set(array(
                'repository' => $i['repo'],
                'name' => $i['name'],
                'username' => (empty($i['username'])) ? '' : $i['username'],
                'password' => (empty($i['password'])) ? '' : $i['password'],
                'key' => $i['key'],
            ));
            
        }
        
//        $ftp = array(
//            'production' => $i['ftp-production'],
//        );
//        
//        if ($a[1] !== 0) {
//            echo json_encode(array(
//                'status' => true,
//                'request' => $i
//            ));
//        }
    }

    public function action_start($id = null) {

        if ($id == null || !Auth::check()) {
            return false;
        }

        $user_id = Auth::get_user_id()[1];
        $deploy = new Model_Deploy();

        /*
         * set repohome.
         */
        $repohome = DOCROOT . 'fuel/repository';

        /*
         * get repo data.
         */
        $repo = $deploy->get($id)[0];

        /*
         * maintain log.
         */
        $log = array();

        $record = new Model_Record();

        /*
         * insert record to maintain.
         */
        $record_id = $record->insert(array(
            'deploy_id' => $repo['id'],
            'status' => 'Working',
            'triggerby' => 'user',
            'date' => time(),
        ));

        $deploy->set($id, array(
            'status' => 'cloning'
        ));

        try {
            File::read_dir($repohome . '/' . $user_id);
        } catch (Exception $e) {
            File::create_dir($repohome, $user_id, 0755);
        }

        $userdir = $repohome . '/' . $user_id;

        try {
            File::read_dir($userdir . '/' . $repo['id']);
        } catch (Exception $ex) {
            File::create_dir($userdir, $repo['id'], 0755);
        }

        $repodir = $userdir . '/' . $repo['id'];

        chdir($userdir);

        exec('git clone --depth 1 ' . $repo['repository'] . ' ' . $repo['id']);

        $a = File::read_dir($repodir);

        if (count($a) == 0) {

            $log['clone'] = 'Error while cloning repository.';
            $log['clone_status'] = false;

            echo json_encode(array(
                'status' => false,
                'reason' => 'There was an error while cloning the repository. The bad news is, we dont know the error'
            ));

            $deploy->set($id, array(
                'cloned' => false,
                'status' => 'to be initialized',
                'deployed' => false,
                'cloned' => false,
            ));

            $record->set($record_id, array(
                'status' => false,
            ));

            return;
        } else {

            $log['clone'] = 'Successfully cloned repository.';
            $log['clone_status'] = true;

            $deploy->set($id, array(
                'cloned' => true,
                'status' => 'uploading'
            ));
        }

        $ftp = $repo['ftp'][0];
        // ftp upload here.

        $gitcore = new gitcore();
        $gitcore->action = array('deploy');
        $gitcore->repo = $repodir;

        $gitcore->ftp = array(
            'scheme' => $ftp['scheme'],
            'host' => $ftp['host'],
            'user' => $ftp['username'],
            'pass' => $ftp['pass'],
            'port' => $ftp['port'],
            'path' => $ftp['path'],
            'passive' => true,
            'skip' => array(),
            'purge' => array()
        );

        $gitcore->revision = '';

        try {
            $gitcore->startDeploy();
        } catch (Exception $ex) {
            array_push($log, $gitcore->log);
            $record->set($record_id, array(
                'raw' => serialize($log),
                'status' => false,
            ));
            return;
        }

        array_push($log, $gitcore->log);

        $record->set($record_id, array(
            'raw' => serialize($log),
            'status' => true,
        ));

        $ftp_data = $repo['ftpdata'];
        $ftp_data['revision'] = $gitcore->currentRevision();

        $deploy->set($id, array(
            'deployed' => true,
            'lastdeploy' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
            'ftp' => serialize($ftp_data),
            'status' => 'Idle',
            'ready' => 1
        ));

        return json_encode(array(
            'status' => true,
        ));

        // lets start
    }

}
