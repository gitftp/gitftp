<?php

class Gfcore {

    public $user_id; // user id
    public $deploy_id; // deploy id
    public $record_id; // record id

    public $m_deploy; // deploy model
    public $m_record; // record model
    public $m_branches; // branches model

    public $repo_home; // repo home path
    public $user_dir; // user path
    public $repo_dir; // repo path
    public $deploy_data; // deploy data
    public $branch_data; // branchs data

    public $log = array(); // logs

    public $debug = FALSE;

    /**
     * @param $id -> deploy id
     * @param $branch -> branch id
     */
    public function __construct($id, $branch_id = null) {
        // collect id.
        $this->deploy_id = $id;
        $this->user_id = Auth::get_user_id()[1];

        // Assign paths
        $this->repo_home = DOCROOT . 'fuel/repository';
        $this->createFolders();

        // collect models.
        $this->m_deploy = new Model_Deploy();
        $this->m_deploy->id = $this->deploy_id;
        $this->m_record = new Model_Record();
        $this->m_branches = new Model_Branch();

        // collect data.
        $this->deploy_data = $this->m_deploy->get()[0];
        $this->branch_data = $this->m_branches->get($this->deploy_id);

        // parseUsernamePassword
        $this->deploy_data['repository'] = $this->parseUsernamePassword($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);

        // which branch
        if (is_null($branch_id)) {
            // deploy to all branches.
        } else {
            $branch = array();
            foreach ($this->branch_data as $k => $v) {
                if ($v['id'] == $branch_id) {
                    array_push($branch, $v);
                    $this->branch_data = $branch;
                    break;
                }
            }
        }
    }

    public function deploy() {
        chdir($this->user_dir);
        $this->cloneRepo();
        $this->upload();
    }

    public function upload() {
        $m_ftp = new Model_Ftp();

        foreach ($this->branch_data as $key => $branch) {
            $ftp_data = $m_ftp->get($branch['ftp_id']);
            $ftp_data = $ftp_data[0];
            $deploy_log = $this->log;

            // create record
            $this->createRecord();
            $this->m_record->set($this->record_id, array(
                'branch_id' => $branch['id'],
                'status'    => 2,
            ));

            // test ftp server connection.
            $ftp_test = utils::test_ftp($ftp_data);

            if ($ftp_test == 'Ftp server is ready to rock.') {
                $deploy_log['ftp_connect'] = 'Connected';
            } else {
                $deploy_log['ftp_connect'] = 'Connection failed: ' . $ftp_test; // failed with reason.
                $this->m_record->set($this->record_id, array(
                    'status' => 0,
                    'raw'    => serialize($deploy_log)
                ));
                continue; // skip to next branch.
            }

            // checkout to branch

            $deploy_log['deploy_branch'] = $branch['branch_name']; // branch name GIT
            $deploy_log['deploy_branch_env'] = $branch['name']; // branch env
            exec('git checkout ' . $branch['branch_name'], $checkCheckoutOp);

            if ($this->debug) {
                $deploy_log['switching_to_branch_op'] = $checkCheckoutOp;
            }
            $deploy_log['revision_on_server_before'] = $branch['revision'];

            $gitcore = new gitcore();
            $gitcore->options = array(
                'record_id' => $this->record_id,
                'repo'      => $this->repo_dir,
                'debug'     => $this->debug,
                'deploy_id' => $this->deploy_id,
                'server'    => 'default',
                'ftp'       => array(
                    'default' => array(
                        'scheme'  => $ftp_data['scheme'],
                        'host'    => $ftp_data['host'],
                        'user'    => $ftp_data['username'],
                        'pass'    => $ftp_data['pass'],
                        'port'    => $ftp_data['port'],
                        'path'    => $ftp_data['path'],
                        'passive' => TRUE,
                        'skip'    => array(),
                        'purge'   => array()
                    )
                ),
                'revision'  => $branch['revision']
            );

            try {
                $gitcore->startDeploy();
            } catch (Exception $e) {
                $deploy_log['deploy_log'] = $gitcore->log;
                $this->m_record->set($this->record_id, array(
                    'raw' => serialize($deploy_log),
                ));
                $this->m_deploy->set(null, array(
                    'cloned'   => 0,
                    'deployed' => 0,
                    'status'   => 'Idle',
                    'ready'    => 0
                ));
                continue; // continue to next branch.
            }

            $deploy_log['revision_on_server_after'] = $deploy_log['deploy_log']['gitftpop']['revision'];
            $deploy_log['deploy_log'] = $gitcore->log;

            if (isset($deploy_log['deploy_log']['gitftpop']['revision'])) {
                $current_revision = $deploy_log['deploy_log']['gitftpop']['revision'];
            } else {
                $current_revision = '';
            }

            $this->m_record->set($this->record_id, array(
                'raw'                 => serialize($deploy_log),
                'status'              => 1,
                'amount_deployed'     => $deploy_log['deploy_log']['gitftpop']['deployed']['human'],
                'amount_deployed_raw' => $deploy_log['deploy_log']['gitftpop']['deployed']['data'],
                'file_add'            => $deploy_log['deploy_log']['gitftpop']['files']['upload'],
                'file_remove'         => $deploy_log['deploy_log']['gitftpop']['files']['delete'],
                'file_skip'           => $deploy_log['deploy_log']['gitftpop']['files']['skip'],
                'hash'                => $current_revision,
            ));

            $this->m_branches->set($branch['id'], array(
                'ready'    => 1,
                'revision' => $current_revision
            ));

            // everything is done, lets checkout to master back
            exec('git checkout master');
            sleep(1);
        }

        $this->m_deploy->set(null, array(
            'deployed' => TRUE,
            'ready'    => TRUE
        ));
    }

    public function createRecord() {
        $this->record_id = $this->m_record->insert(array(
            'deploy_id' => $this->deploy_id,
            'status'    => 2,
            'triggerby' => 'System (first deploy)',
            'date'      => time(),
        ));
    }

    public function createFolders() {
        try {
            File::read_dir($this->repo_home . '/' . $this->user_id);
        } catch (Exception $e) {
            File::create_dir($this->repo_home, $this->user_id, 0755);
        }
        $this->user_dir = $this->repo_home . '/' . $this->user_id;
        try {
            File::read_dir($this->user_dir . '/' . $this->deploy_id);
        } catch (Exception $ex) {
            File::create_dir($this->user_dir, $this->deploy_id, 0755);
        }
        $this->repo_dir = $this->user_dir . '/' . $this->deploy_id;
    }

    public function parseUsernamePassword($url, $username, $password) {
        if (!empty($username)) {
            $repo_url = parse_url($url);
            $repo_url['user'] = $username;

            if (!empty($password)) {
                $repo_url['pass'] = $password;
            }
            $url = http_build_url($repo_url);
        }

        return $url;
    }

    public function cloneRepo() {

        $this->m_deploy->set(null, array(
            'cloned' => 2
            // working
        ));
        // clone the repository depth 1.
        exec('git clone --depth 1 ' . $this->deploy_data['repository'] . ' ' . $this->deploy_data['id'] . ' --progress 2>&1', $gitOutput);
        chdir($this->repo_dir);
        exec("git remote set-branches origin '*'", $gitOutput);
        exec('git fetch -vvv --progress 2>&1', $gitOutput);
        exec('git checkout master', $gitOutput);

        if ($this->debug) {
            $this->log['repo_output'] = $gitOutput;
        }

        /*
         * Check if repository is cloned !!!!
         */
        try {
            $dir_read = File::read_dir($this->repo_dir);
        } catch (Exception $ex) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(null, array(
                'cloned'   => 0,
                'deployed' => 0
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check if repository is cloned !!!!
         */
        if (count($dir_read) == 0) {
            $this->log['repo_processed'] = 'No';
            $this->m_deploy->set(null, array(
                'cloned'   => FALSE,
                'deployed' => FALSE
            ));
            throw new Exception('Failed to clone repo: ' . $this->deploy_data['repository']);
        } else {
            $this->log['repo_processed'] = 'Yes';
            $this->m_deploy->set(null, array(
                'cloned'   => TRUE,
                'deployed' => FALSE
            ));
        }
    }

    // this is junk, just for reference purpose.
    public function action_deploy($id = null) {

        $ftp = $repo['ftp'][0];
        // ftp upload here.

        $gitcore = new gitcore();
        /*
         * check if ftp server is proper.
         */
        $ftp_test_data = utils::test_ftp($ftp);

        if ($ftp_test_data != 'Ftp server is ready to rock.') {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => $ftp_test_data
            ));
            $log['ftpconnectstatus'] = $ftp_test_data;
            array_push($log, $gitcore->log);
            $record->set($record_id, array(
                'raw'    => serialize($log),
                'status' => 0,
            ));
            $deploy->set($id, array(
                'cloned'   => 0,
                'deployed' => 0,
                'status'   => 'to be initialized',
                'ready'    => 0
            ));
            die();
        }

        $gitcore->options = array(
            'repo'      => $repodir,
            'debug'     => FALSE,
            'deploy_id' => $id,
            'server'    => 'default',
            'ftp'       => array(
                'default' => array(
                    'scheme'  => $ftp['scheme'],
                    'host'    => $ftp['host'],
                    'user'    => $ftp['username'],
                    'pass'    => $ftp['pass'],
                    'port'    => $ftp['port'],
                    'path'    => $ftp['path'],
                    'passive' => TRUE,
                    'skip'    => array(),
                    'purge'   => array()
                )
            ),
            'revision'  => '',
        );

        try {
            $gitcore->startDeploy();
        } catch (Exception $ex) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => 'Failed to connect to ftp server, or the destination directory not found, or no permissions granted.<br><code>ERROR: ' . $ex->getMessage() . '</code>'
            ));
            array_push($log, $gitcore->log);
            $record->set($record_id, array(
                'raw'    => serialize($log),
                'status' => 0,
            ));
            $deploy->set($id, array(
                'cloned'   => 0,
                'deployed' => 0,
                'status'   => 'to be initialized',
                'ready'    => 0
            ));

            return;
        }

        $log['gitftpop'] = $gitcore->log;

        $record->set($record_id, array(
            'raw'                 => serialize($log),
            'status'              => 1,
            'amount_deployed'     => $log['gitftpop']['gitftpop']['deployed']['human'],
            'amount_deployed_raw' => $log['gitftpop']['gitftpop']['deployed']['data'],
            'file_add'            => $log['gitftpop']['gitftpop']['files']['upload'],
            'file_remove'         => $log['gitftpop']['gitftpop']['files']['delete'],
            'file_skip'           => $log['gitftpop']['gitftpop']['files']['skip'],
        ));

        $ftp_data = $repo['ftpdata'];
        $ftp_data['revision'] = $log['gitftpop']['gitftpop']['revision'];

        //        $deploy->set($id, array(
        //            'deployed'   => TRUE,
        //            'lastdeploy' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
        //            'ftp'        => serialize($ftp_data),
        //            'status'     => 'Idle',
        //            'ready'      => 0
        //        ));

        return json_encode(array(
            'status' => TRUE
        ));

        // lets start
    }

}

/* end of file Gfcore.php */
