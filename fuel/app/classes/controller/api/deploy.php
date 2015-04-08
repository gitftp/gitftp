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
        
        if ($status != 'idle' or $status != 'not initialized') {
            return json_encode(array(
                'status' => false,
                'reason' => 'deploy busy, unable to delete in between of work',
                'request' => $id
            ));
        }

        $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $b[0]['name'];
        chdir($repo_dir);
        echo shell_exec('chown www-data * -R');
        echo shell_exec('chgrp www-data * -R');
        echo shell_exec('chmod 777 -R');
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
        $deploy = new Model_Deploy();
        $repohome = DOCROOT . 'fuel/repository';
        $repo = $deploy->get($id)[0];
        $log = array();
        $record = new Model_Record();

        $record_id = $record->insert(array(
            'deploy_id' => $repo['id'],
            'status' => 'working',
            'triggerby' => 'user',
        ));

        $deploy->set($id, array(
            'status' => 'First deploy: Cloning..'
        ));

        try {
            File::read_dir($repohome . '/' . $user_id);
        } catch (Exception $e) {
            File::create_dir($repohome, $user_id, 0755);
        }

        $userdir = $repohome . '/' . $user_id;

        try {
            File::read_dir($userdir . '/' . $repo['name']);
        } catch (Exception $ex) {
            File::create_dir($userdir, $repo['name'], 0755);
        }

        $repodir = $userdir . '/' . $repo['name'];

        chdir($userdir);

        exec('git clone ' . $repo['repository'] . ' ' . $repo['name']);

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
                'status' => 'Not initialized'
            ));
        } else {

            $log['clone'] = 'Successfully cloned repository.';
            $log['clone_status'] = true;

            $deploy->set($id, array(
                'cloned' => true,
                'status' => 'First deploy: Uploading..'
            ));
        }

        $ftp_id = unserialize($repo['ftp'])['production'];
        $ftp = DB::select()->from('ftpdata')->where('id', $ftp_id)->execute()->as_array()[0];
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
        $gitcore->startDeploy();
        array_push($log, $gitcore->log);

        $record->set($record_id, array(
            'raw' => serialize($log),
            'status' => true
        ));

        $ftp_data = unserialize($repo['ftp']);
        $ftp_data['revision'] = $gitcore->currentRevision();

        $deploy->set($id, array(
            'deployed' => true,
            'lastdeploy' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
            'ftp' => serialize($ftp_data),
            'status' => 'Idle'
        ));

        return json_encode(array(
            'status' => true,
        ));

        // lets start
    }

}
