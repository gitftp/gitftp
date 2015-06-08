<?php

class Gfcore {

    public $user_id; // user id.
    public $deploy_id; // deploy id.
    public $record_id; // record id.

    // models
    public $m_deploy;
    public $m_record;
    public $m_branches;

    // data
    public $repo_home; // repo home path
    public $user_dir; // user path
    public $repo_dir; // repo path
    public $deploy_data; // deploy data

    // logs
    public $debug = TRUE; // gives verbose op.
    public $log = array(); // logs

    /*
     * record to process.
     */
    public $record;

    /**
     * @param $id -> deploy id
     * @param $branch -> branch id
     */
    public function __construct($id) {
        // collect id.
        $this->deploy_id = $id;

        // Assign paths
        $this->repo_home = DOCROOT . 'fuel/repository';

        // collect models.
        $this->m_record = new Model_Record();
        $this->m_deploy = new Model_Deploy();
        $this->m_deploy->id = $this->deploy_id;
        $this->m_branches = new Model_Branch();

        // collect data.
        $this->get_deploy_data();
        $this->user_id = $this->deploy_data['user_id'];
        $this->createFolders();

        utils::log('userid: '.$this->user_id);
        utils::log('deploy id: '.$this->deploy_id);
        utils::log($this->repo_home);
        utils::log(getcwd());
    }

    public function get_deploy_data() {
        $this->deploy_data = $this->m_deploy->get()[0];
        $this->deploy_data['repository'] = $this->parseUsernamePassword($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);
    }

    public function deploy() {
        chdir($this->repo_dir);
        $is_active = $this->m_record->is_queue_active($this->deploy_id);

        if ($is_active) {
            die('deploy is already running or there is nothing to deploy');
        }

        // THIS IS A LOOP.
        $this->log = array();
        $this->get_deploy_data(); //updating new data.
        $this->record = $this->m_record->get_next_from_queue($this->deploy_id);
        $this->record_id = $this->record['id'];
        echo "processing $this->record_id <br>";
        // on your mark!
        $this->m_record->set($this->record_id, array(
            'status' => $this->m_record->in_progress
        ));

        if ($this->deploy_data['cloned']) {
            $this->log['what'] = 'pulling';
            $this->pullRepo();
        } else {
            $this->log['what'] = 'cloning';
            $this->cloneRepo();
        }

        try {
            $this->upload();
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->success
            ), TRUE);
            $this->m_branches->set($this->record['branch_id'], array(
                'ready' => 1
            ), TRUE);
            $this->deploy();
        } catch (Exception $e) {
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed
            ), TRUE);
            echo $e->getMessage();
            echo $e->getLine();
            echo $e->getFile();
            $this->deploy();
        }

    }

    public function upload() {
        $m_ftp = new Model_Ftp();

        $branch_id = $this->record['branch_id'];
        $branch = $this->m_branches->get_by_branch_id($branch_id)[0]; // this is the branch to deploy from.
        $ftp_data = $m_ftp->get($branch['ftp_id'])[0]; // this is the ftp to deploy to.

        $ftp_test = utils::test_ftp($ftp_data);

        if ($ftp_test == 'Ftp server is ready to rock.') {
            $this->log['ftp_connect'] = 'Connected';
        } else {
            $this->log['ftp_connect'] = 'Connection failed: ' . $ftp_test; // failed with reason.
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log)
            ));
            throw new Exception('Something went wrong, and taken care of');
        }

        // checkout to branch
        $this->log['deploy_branch'] = $branch['branch_name']; // branch name GIT
        $this->log['deploy_branch_env'] = $branch['name']; // branch env
        exec('git checkout ' . $branch['branch_name'], $checkCheckoutOp);

        if ($this->debug) {
            $this->log['switching_to_branch_op'] = $checkCheckoutOp;
        }
        $this->log['revision_on_server_before'] = $branch['revision'];

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
            $this->log['deploy_log'] = $gitcore->log;

            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log),
            ));

            throw new Exception('Something went wrong while deployment. taken care of.');
        }

        $this->log['deploy_log'] = $gitcore->log;

        //        if (empty($branch['revision'])) {
        //            if (isset($this->log['deploy_log']['gitftpop']['revision'])) {
        //                $current_revision = $this->log['deploy_log']['gitftpop']['revision'];
        //            } else {
        //                $current_revision = '';
        //            }
        //        } else {
        //            if (!isset($this->log['deploy_log']['gitftpop']['revision'])) {
        //                $current_revision = $branch['revision'];
        //            }
        //        }

        $before_revision = $this->log['deploy_log']['gitftpop']['revision_before'];
        $current_revision = $this->log['deploy_log']['gitftpop']['revision'];
        $this->log['revision_on_server_after'] = $current_revision;

        $this->m_record->set($this->record_id, array(
            'raw'                 => serialize($this->log),
            'amount_deployed'     => $this->log['deploy_log']['gitftpop']['deployed']['human'],
            'amount_deployed_raw' => $this->log['deploy_log']['gitftpop']['deployed']['data'],
            'file_add'            => $this->log['deploy_log']['gitftpop']['files']['upload'],
            'file_remove'         => $this->log['deploy_log']['gitftpop']['files']['delete'],
            'file_skip'           => $this->log['deploy_log']['gitftpop']['files']['skip'],
            'hash'                => $current_revision,
            'hash_before'         => $before_revision,
        ));

        $this->m_branches->set($branch['id'], array(
            'ready'    => 1,
            'revision' => $current_revision
        ));

        // everything is done, lets checkout to master back
        exec('git checkout master');
        sleep(1);

        $this->m_deploy->set(null, array(
            'deployed' => TRUE,
            'ready'    => TRUE
        ));
    }

    /**
     * Create users and repo folder in repository folder.
     * make sure its there.
     *
     * @throws FileAccessException
     * @throws InvalidPathException
     */
    public function createFolders() {

        // user folder.
        try {
            File::read_dir($this->repo_home . '/' . $this->user_id);
        } catch (Exception $e) {
            File::create_dir($this->repo_home, $this->user_id, 0755);
        }
        $this->user_dir = $this->repo_home . '/' . $this->user_id;

        // repo folder.
        try {
            File::read_dir($this->user_dir . '/' . $this->deploy_id);
        } catch (Exception $ex) {
            File::create_dir($this->user_dir, $this->deploy_id, 0755);
        }
        $this->repo_dir = $this->user_dir . '/' . $this->deploy_id;

        chdir($this->repo_dir);
    }

    /**
     * Parse the repo URL with usernamd and password.
     *
     * @param $url
     * @param $username
     * @param $password
     * @return string
     */
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

    /**
     * Clone the repo.
     *
     * @throws Exception
     */
    public function cloneRepo() {
        chdir($this->user_dir);
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
                'cloned'   => FALSE,
                'deployed' => FALSE
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check if repository is cloned !!!!
         */
        try {
            $gitfolder = File::read_dir($this->repo_dir . '/.git', 0);
        } catch (Exception $e) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(null, array(
                'cloned'   => FALSE,
                'deployed' => FALSE
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check if reposuitroy is cloned !!!!
         */
        if (count($gitfolder) == 0) {
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

    /**
     * Pull the repo.
     */
    public function pullRepo() {

        chdir($this->repo_dir);

        if ($this->debug) {
            $this->log['pull_working'] = 'Pulling repo';
        }

        exec('git pull --rebase', $pullop);
        exec('git fetch --all', $pullop);
        exec('git reset --hard origin/master', $pullop);

        if ($this->debug) {
            $this->log['pull_op'] = $pullop;
        } else {
            $this->log['pull_op'] = 'success';
        }

    }
}

/* end of file Gfcore.php */
