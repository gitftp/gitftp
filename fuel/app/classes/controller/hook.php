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

        $repo = $repo[0];
        $i = $_REQUEST['payload'];
        $i = json_decode($i);
        $log = array();

        $record = new Model_Record();
        $deploy = new Model_Deploy();

        list($record_id, $asd) = DB::insert('records')->set(array(
                    'deploy_id' => (int) $deploy_id,
                    'user_id' => (int) $user_id,
                    'status' => 2,
                    'date' => time(),
                    'raw' => serialize($log),
                    'triggerby' => $i->pusher->name,
                    'avatar_url' => $i->sender->avatar_url,
                    'hash' => $i->after,
                    'post_data' => serialize($i),
                    'commit_count' => count($i->commits),
                    'commit_message' => $i->commits[0]->message
                ))->execute();

        $deploy->set($deploy_id, array(
            'status' => 'processing'
                ), true);

        $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deploy_id;
        $log['dir'] = $repo_dir;
        chdir($repo_dir);
        $log['hook'] = 'POST hook received, starting with deploy';

        $cmdpull = shell_exec('git pull --rebase');
        $log['pull'] = $cmdpull;
        $cmdfetch = shell_exec('git fetch --all');
        $log['fetch'] = $cmdfetch;
        $cmdreset = shell_exec('git reset --hard origin/master');
        $log['reset'] = $cmdreset;

        $ftp = unserialize($repo['ftp']);
        $ftpdata = DB::select()->from('ftpdata')->where('id', $ftp['production'])->execute()->as_array();
        $ftpdata = $ftpdata[0];

        $deploy->set($deploy_id, array(
            'status' => 'deploying'
                ), true);

        $gitcore = new gitcore();
        $gitcore->options = array(
            'repo' => $repo_dir,
            'debug' => true,
            'server' => 'default',
            'ftp' => array(
                'default' => array(
                    'scheme' => $ftpdata['scheme'],
                    'host' => $ftpdata['host'],
                    'user' => $ftpdata['username'],
                    'pass' => $ftpdata['pass'],
                    'port' => $ftpdata['port'],
                    'path' => $ftpdata['path'],
                    'passive' => true,
                    'skip' => array(),
                    'purge' => array()
                )
            ),
            'revision' => $ftp['revision'],
        );
        
        try {
            $gitcore->startDeploy();
        } catch (Exception $ex) {

            array_push($log, $gitcore->log);
            $record->set($record_id, array(
                'raw' => serialize($log),
                'status' => 0,
                    ), true);

            print_r($log);

            $deploy->set($deploy_id, array(
                'status' => 'Idle'
                    ), true);

            return;
        }

        $log['gitftpop'] = $gitcore->log;
        print_r($log);

        $record->set($record_id, array(
            'raw' => serialize($log),
            'status' => 1,
            'amount_deployed' => $log['gitftpop']['gitftpop']['deployed']['human'],
            'amount_deployed_raw' => $log['gitftpop']['gitftpop']['deployed']['data'],
            'file_add' => serialize($log['gitftpop']['gitftpop']['files']['upload']),
            'file_remove' => serialize($log['gitftpop']['gitftpop']['files']['delete']),
            'file_skip' => serialize($log['gitftpop']['gitftpop']['files']['skip']),
                ), true);

        $ftp['revision'] = $log['gitftpop']['gitftpop']['revision'];
        echo '------------';
        print_r($ftp);
        echo '------------';

        $deploy->set($deploy_id, array(
            'deployed' => true,
            'lastdeploy' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
            'ftp' => serialize($ftp),
            'status' => 'Idle',
            'ready' => 1
                ), true);
    }

    public function action_get() {
        echo '<pre>';
        $a = DB::select()->from('test')->execute()->as_array();
        print_r($a[1])
        print_r(json_decode(unserialize($a[1]['payload'])));
        
    }
    public function action_put(){
        DB::insert('test')->set(array(
            'test' => serialize($_REQUEST)
        ))->execute();
    }
}
