<?php

use \Symfony\Component\Process\Process;

/**
 * Class Gfcore
 *
 * Main deployment class.
 * Runs on CLI
 */
class Gfcore {
    public $user_id; // current user
    public $deploy_id; // current deploy
    public $record_id; // iterated record id. that changes
    public $record; // iterated record. that changes.
    public $branch; // iterated branch. that changes.

    public $m_deploy; // deploy modal
    public $m_record; // record modal
    public $m_branches; // branch modal

    public $repo_home; // repo home (fuel/repository)
    public $user_dir; // user directory.
    public $repo_dir; // repo directory.

    public $data; //An assoc array from DB of the currently being deployed data.
    public $debug = TRUE; // Verbose output.

    public $log = array(); // Used to collect logs, (to be stored in records raw.)
    public $gitapi; // Git API helper class.
    public $is_cloned; // is the project cloned.

    /**
     * Get ready with all the data we need,
     * @param $deploy_id
     * @throws \Craftpip\Exception
     * @internal param $id -> deploy id
     */
    public function __construct($deploy_id) {
        $this->deploy_id = $deploy_id;
        $this->repo_home = DOCROOT . 'fuel/repository';
        $this->m_deploy = new \Model_Deploy();
        $this->m_deploy->id = $this->deploy_id;
        $data = $this->m_deploy->get(NULL, NULL, TRUE);
        if (count($data) !== 1) {
            throw new \Craftpip\Exception("Project does not exist.");
        } else {
            $this->data = $data[0];
        }

        $this->user_id = $this->data['user_id'];
        $this->m_deploy->user_id = $this->user_id;
        $this->m_record = new \Model_Record($this->user_id);
        $this->m_branches = new \Model_Branch($this->user_id);
        $this->is_cloned = ($this->data['cloned'] == 1) ? TRUE : FALSE;
        $this->gitapi = new \Craftpip\GitApi($this->user_id); // get GIT API HELPER.
        $this->provider = strtolower(\Utils::parseProviderFromRepository($this->data['repository'])); // get current provider
        $this->clone_url = $this->gitapi->parseRepositoryCloneUrl($this->data, $this->provider); // get clone url.
        $this->createFolders(); // create necessary folders on disk.
        chdir($this->repo_dir); // change to repo dir !!!. we are on repo dir forever. NO NEED TO CHANGE IT LATER.
        $this->output('Current directory: ' . getcwd());

        /*
         * Handle traditional errors. Instead throw exceptions.
         */
        $old_error_handler = set_error_handler(array(
            $this,
            'error_handler'
        ));
    }

    /**
     * Iterating over records.
     * @throws Exception
     */
    public function deploy() {
        // Check if its currenly being deployed. If active, die.
        $is_active = $this->m_record->is_queue_active($this->deploy_id);
        if ($is_active) {
            die("The queue is already running.\n"); // not to move forward.
        }

        // Get a record from queue.
        $this->record = $this->m_record->get_next_from_queue($this->deploy_id);
        if ($this->record == FALSE) {
            die("The queue is over.\n"); // not to move forward.
        }

        $this->output('=============================================');
        $this->output('=========== Initializing deploy. ============');
        $this->output('=============================================');

        $this->log = array(); // empty the log for new logs for the new record.
        $this->record_id = $this->record['id']; // This record will be processed.
        $this->m_record->set($this->record_id, array( // Setting this record_id in progress.
            'status' => $this->m_record->in_progress
        ));
        // WE ARE IN CHARGE OF THIS RECORD'S SAFETY! BUKLE UP.
        $this->output('starting with record id: ' . $this->record_id);

        try {
            // Testing connection for safety.
            $this->output($this->clone_url);
            try {
                $branches = \Utils::gitGetBranches2($this->clone_url);
            } catch (Exception $e) {
                $this->log('repo_connect', 'ERROR: Could not connect to repository. REASON: '.$e->getMessage());
                throw new \Exception($e->getMessage());
            }

            $this->output(is_array($branches) ? 'found branches ' . implode(', ', $branches) : 'no branches found.');
            $this->output('Fetched ' . count($branches) . ' branches');
            $this->log('repo_connect', 'Connection to ' . $this->deploy_data['repository'] . ' successful.');

            // here is where the cloning comes in,
            if($this->record['record_type'] == $this->m_record->type_first_clone){ // clone only.
                if (!$this->is_cloned) {
                    $this->output('Cloning repo');
                    $this->cloneRepo();
                } else {
                    $this->output('Pulling repo');
                    $this->pullRepo();
                }
            }else{
                // Getting branch data of the respective RECORD.
                $branch_id = $this->record['branch_id']; // this is not set if on clone only type.
                $branch = $this->m_branches->get_by_branch_id($branch_id);
                if (count($branch) !== 1) {
                    throw new Exception('Branch/Environment not found.');
                } else {
                    $this->branch = $branch[0];
                }

                if (!$this->is_cloned) {
                    $this->output('Cloning repo');
                    $this->cloneRepo();
                } else {
                    $this->output('Pulling repo');
                    $this->pullRepo($this->branch['branch_name']);
                }

                // Okay, Start uploading the changed files.
                $this->upload();

            }

            // Okay, set to success and move on.
            $this->output('Success with record id: ' . $this->record_id);

            $this->m_branches->set($this->record['branch_id'], array(
                'ready' => 1
            ), TRUE);

            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->success
            ), TRUE);
        } catch (Exception $e) {
            /*
             * IF SHIT GOES TO HELL.
             * set record as failed, store logs and GTFO.
             */
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log)
            ), TRUE);

            \Utils::gitCommand('checkout master'); // failed? reset to master
            $this->output('Shit went to hell! ' . $e->getMessage(), 'white', 'red');
            // Lets iterate.
        }

        // Pheww!, That was tough! NEXT!
        $this->deploy();
    }

    public function error_handler($errno, $errstr, $errfile, $errline) {
        /* Don't execute PHP internal error handler */
        return TRUE;
    }

    /**
     * Upload module.
     * Compares files, and uploads them to the FTP server.
     *
     * @throws Exception
     */
    public function upload() {
        // FYI. We are on master now.
        $m_ftp = new \Model_Ftp();
        $m_ftp->user_id = $this->user_id;
        $branch = $this->branch;
        // Get ftp data for the respective branch
        $ftp_data = $m_ftp->get($branch['ftp_id']);

        if (count($ftp_data) !== 1) {
            $this->log('Failed: Enviornment does not have a Linked FTP account.');
            throw new Exception("No Linked FTP for enviornment.");
        } else {
            $ftp_data = $ftp_data[0];
        }

        // Testing if the FTP server works.
        try {
            $ftp_data['user'] = $ftp_data['username'];
            $ftp_url = http_build_url($ftp_data);
//            $ftp_test = utils::test_ftp($ftp_url);
            $ftp_test = new \Banago\Bridge\Bridge($ftp_url);
            if ($ftp_test) {
                $this->log('ftp_connect', 'connected');
            }
        } catch (Exception $e) {
            $this->log('ftp_connect', 'connection failed: ' . $e->getMessage());
            throw new Exception('We are sending msg here.' . $e->getMessage());
        }

        // LOG --------------------------------
        $this->log('deploy_branch', $branch['branch_name']);
        $this->log('deploy_branch_env', $branch['name']);
        $this->output('Deploy to branch name: ' . $branch['branch_name']);
        // LOG END ----------------------------

        /*
         * Data is ready, need to get ready with repository state.
         * Has to be checked out to the branch specified
         * and has to be checked out to the commit specified.
         */

        /*
         * pull and clone done,
         * checkout to branch now.
         */

        $this->output('Checkout to ' . $branch['branch_name']);
        \Utils::gitCommand("checkout " . $this->branch['branch_name']);
        $this->log('revision_on_server_before', $branch['revision']);
        $this->output('Revision on FTP: ' . $branch['revision']);

        // Setting options for gitcore
        $options = array(
            'record_id'      => $this->record_id,
            'repo'           => $this->repo_dir,
            'debug'          => $this->debug,
            'deploy_id'      => $this->deploy_id,
            'server'         => 'default',
            'ftp'            => array(
                'default' => array(
                    'scheme'  => $ftp_data['scheme'],
                    'host'    => $ftp_data['host'],
                    'user'    => $ftp_data['username'],
                    'pass'    => $ftp_data['pass'],
                    'port'    => $ftp_data['port'],
                    'path'    => $ftp_data['path'],
                    'passive' => TRUE,
                    'skip'    => unserialize($this->branch['skip_path']),
                    'purge'   => unserialize($this->branch['purge_path']),
                )
            ),
            'remoteRevision' => $branch['revision'],
        );

        // if type_rollback.
        if ($this->record['record_type'] == $this->m_record->type_rollback && !empty($this->record['hash'])) {
            // checkout the the specific hash.
            \Utils::gitCommand('checkout ' . $this->record['hash']);
        }

        // if type_sync
        if ($this->record['record_type'] == $this->m_record->type_sync) {
            // upload all files please.
            $options['remoteRevision'] = '';
        }

        if ($this->record['record_type'] == $this->m_record->type_service_push) {
            // push from github/bitbucket.
            if (!empty($this->record['hash']))
                \Utils::gitCommand('checkout ' . $this->record['hash']);
        }

        // else its update

        $localRevision = \Utils::gitCommand('rev-parse HEAD');
        if (isset($localRevision[0])) {
            $localRevision = trim($localRevision[0]);
            $options['localRevision'] = $localRevision;
        }

        if ($options['localRevision'] == $options['remoteRevision']) {
            $this->output('FTP server has the latest changes!');
            $this->log('FTP server has the latest changes!');
        }

        $this->output($localRevision);

        $gitcore = new \Gitcore($options);
        try {
            // todo: we're inside.
            $gitcore->startDeploy();
        } catch (Exception $e) {
            // Store logs from GITCORE.
            $this->log('deploy_log', $gitcore->log);
            $this->output($this->log);
            throw new \Exception($e->getMessage());
        }

        // Store Logs from GITCORE.
        $this->log['deploy_log'] = $gitcore->log;
        $this->output($this->log);

        $before_revision = $this->log['deploy_log']['remoteRevision_before'];
        $current_revision = $this->log['deploy_log']['remoteRevision_after'];

        // Storing output from GITCORE.
        $this->m_record->set($this->record_id, array(
            'raw'                 => serialize($this->log),
            'amount_deployed'     => $this->log['deploy_log']['deployed']['human'],
            'amount_deployed_raw' => $this->log['deploy_log']['deployed']['data'],
            'file_add'            => $this->log['deploy_log']['files']['upload'],
            'file_remove'         => $this->log['deploy_log']['files']['delete'],
            'file_skip'           => $this->log['deploy_log']['files']['skip'],
            'hash'                => $current_revision,
            'hash_before'         => $before_revision,
        ));

        // OK,
        // Update branch to ready,
        // Update branch revision.
        $this->m_branches->set($branch['id'], array(
            'ready'    => 1,
            'revision' => $current_revision
        ));

        // OK, checkout to master.
        \Utils::gitCommand('checkout master');
    }

    /**
     * Create users and repo folder in repository folder.
     * make sure its there.
     *
     * @throws FileAccessException
     * @throws InvalidPathException
     */
    public function createFolders() {
        $this->output('Current directory: ' . getcwd());

        // user folder.
        try {
            \File::read_dir($this->repo_home . '/' . $this->user_id);
            $this->output('User directory already exist.');
        } catch (Exception $e) {
            $p = new Process('mkdir ' . $this->repo_home . '/' . $this->user_id);
            $p->run();
            $this->output('Created user Directory: ' . $this->user_dir);
        }
        $this->user_dir = $this->repo_home . '/' . $this->user_id;

        // repo folder.
        try {
            \File::read_dir($this->user_dir . '/' . $this->deploy_id);
            $this->output('Repository directory already exist.');
        } catch (Exception $ex) {
            $p = new Process('mkdir ' . $this->user_dir . '/' . $this->deploy_id);
            $p->run();
            $this->output('Created repository directory: ' . $this->repo_dir);
        }
        $this->repo_dir = $this->user_dir . '/' . $this->deploy_id;
    }

    /**
     * Clone the repo.
     *
     * @throws Exception
     */
    public function cloneRepo() {
        // Repo is being cloned, set to working
        // 2 -> working
        // 1 -> success
        // 0 -> failed
        $this->m_deploy->set(NULL, array(
            'cloned' => 2
        ));

        // if clone had failed, and may have some files in the folder.
        // delete those first.
        try {
            $dir_read = \File::read_dir($this->repo_dir);
            if(count($dir_read) != 0){
                // there are files in there !.
                exec('rm * -R'); // remove all files recursively
            }
        } catch (Exception $e) {
        }

        // Clone the repository depth 1.
//        \Utils::gitCommand('clone ' . $this->clone_url . ' .');
        exec('git clone ' . $this->clone_url . ' . --progress 2>&1');
//        exec('git clone --depth 1 ' . $this->deploy_data['repository'] . ' . --progress 2>&1', $gitOutput);
        // Set branches to *
        \Utils::gitCommand("remote set-branches origin '*'");
//        exec("git remote set-branches origin '*'", $gitOutput);
        // Fetch all branches from remote
        \Utils::gitCommand('fetch -vvv --progress 2>&1');
//        exec('git fetch -vvv --progress 2>&1', $gitOutput);
//        $this->output($gitOutput);

        /*
         * Try reading the Repo directory.
         */
        try {
            // read the directory.
            $dir_read = \File::read_dir($this->repo_dir);
        } catch (Exception $ex) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new \Exception('The folder could not be read, please try again later.');
        }

        /*
         * Try reading the .git directory.
         */
        try {
            $gitfolder = \File::read_dir($this->repo_dir . '/.git', 0);
        } catch (Exception $e) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new \Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check for content inside .git folder.
         */
        if (count($gitfolder) == 0) {
            $this->log['repo_processed'] = 'No';
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new \Exception('Failed to clone repo: ' . $this->deploy_data['repository']);
        } else {
            $this->log['repo_processed'] = 'Yes';
            $this->m_deploy->set(NULL, array(
                'cloned' => TRUE,
            ));
        }
        $this->output('Clone OK.');
    }

    /**
     * Pull the repo when its already cloned.
     */
    public function pullRepo($branchName = null) {

        if(is_null($branchName)){
            // pull all branches
            \Utils::gitCommand('pull --all');
            exec('git pull --all', $pullop);
            // fetch all brnaches
            \Utils::gitCommand('fetch --all');
//            exec('git fetch --all', $pullop);
        }else{
            // checkout to the branch which we have to pull.
//            exec('git checkout ' . $branchName, $op);
            \Utils::gitCommand('checkout ' . $branchName);
            $this->output('Checkout to ' . $branchName);
            // pull all branches
            \Utils::gitCommand('pull --all');
//            exec('git pull --all', $pullop);
            // fetch all brnaches
            \Utils::gitCommand('fetch --all');
//            exec('git fetch --all', $pullop);
            // reset all local files and make exact copy of remote
            \Utils::gitCommand('reset --hard origin/' . $branchName);
//            exec('git reset --hard origin/' . $branchName, $pullop);
            /*
             * Go back to master.
             */
            if ($branchName !== 'master') {
//                exec('git checkout master');
                \Utils::gitCommand('checkout master');
            }
        }
    }

    /**
     * ALL OK
     * Print on screen
     *
     * @param $message
     */
    public function output($message, $color = 'black', $bgcolor = 'green') {
        if ($this->debug) {
            if (is_array($message)) {
                $message = print_r($message, TRUE);
            }
            \Cli::write("~ $message", $color, $bgcolor);
        }
    }

    /**
     * ALL OK
     * Log progress and errors for the user to view.
     *
     * @param $message
     */
    public function log($a, $b = NULL) {
        if (is_null($b)) {
            $this->log[] = $a;
        } else {
            $this->log[$a] = $b;
        }
    }

    /**
     * ALL OK
     * This function initiates the deploy in background process.
     * Using Fuelphp task runner.
     *
     * @return bool
     */
    public static function deploy_in_bg($deploy_id) {
        shell_exec('FUEL_ENV=' . \Fuel::$env . ' php /var/www/html/oil refine crontask:deploy ' . $deploy_id . ' > /dev/null 2>/dev/null &');

        return TRUE;
    }
}

/* end of file Gfcore.php */