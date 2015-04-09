<?php

class Controller_Hook extends Controller {

    public function action_index() {
        echo '';
    }

    public function action_i($user_id = null, $deploy_id = null, $key = null) {

        if ($user_id == null || $deploy_id == null || $key == null || Input::method() != 'POST') {
            die('Something is missing');
        }

        $repo = DB::select()->from('deploy')->where('id', $deploy_id)->and_where('user_id', $user_id)
                        ->execute()->as_array();

        if (count($repo) == 0) {
            die('No such user or deploy found.');
        } else {
            if ($key != $repo[0]['key']) {
                die('The key provided doesnt match');
            }
        }

        $i = $_REQUEST['payload'];
        $i = json_decode($i);
        $log = array();

        $record = new Model_Record();

        list($record_id, $asd) = DB::insert('records')->set(array(
                    'deploy_id' => (int) $deploy_id,
                    'user_id' => (int) $user_id,
                    'status' => 2,
                    'date' => time(),
                    'triggerby' => $i->pusher->name,
                    'avatar_url' => $i->sender->avatar_url,
                    'post_data' => serialize($i),
                    'commit_count' => count($i->commits),
                    'commit_message' => $i->commits[0]->message
                ))->execute();

        $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deploy_id;
        
        chdir($repo_dir);
        $log['hook'] = 'POST hook received, starting with deploy';
        
        exec('git pull --rebase --depth=1', $cmdpull);
        $log['pull'] = $cmdpull;
        exec('git fetch --all', $cmdfetch);
        $log['fetch'] = $cmdfetch;
        exec('git reset --hard origin/master', $cmdreset);
        $log['reset'] = $cmdreset;
        
        $ftp = unserialize($repo['ftp']);
        
        $ftpdata = DB::select()->from('ftpdata')->where('id', $ftp['production'])
        
        $gitcore = new gitcore();
        $gitcore->action = array('deploy');
        $gitcore->repo = $repo_dir;

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
