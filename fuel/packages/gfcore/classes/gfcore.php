<?php

use \Symfony\Component\Process\Process;

/**
 * Class Gfcore
 *
 * takes a deploy_id,
 * checks the queue of the given deploy
 * iterates over and deploys the records one by one.
 * stops if the deploy_id is already being deploys, (if this class is already called and active)
 */
class Gfcore {
    /*
     * The user_id (users to map git path).
     */
    public $user_id;
    /*
     * The deploy_id, that is passed
     */
    public $deploy_id;
    /*
     * This is overwritten by the iterated records.
     * (currently processed record.)
     */
    public $record_id;
    /*
     * record data from DB that is currently being iterated.
     * (currently processed record data.)
     */
    public $record;
    /*
     * records's branch that is being deployed.
     */
    public $branch;

    // models
    public $m_deploy;
    public $m_record;
    public $m_branches;

    /*
     * Repo home, (fuel/repository)
     */
    public $repo_home;
    /*
     * user directory appended to repo home.
     */
    public $user_dir;
    /*
     * Repo directory appended to user dir.
     */
    public $repo_dir;
    /*
     * An assoc array from DB of the currently being deployed data.
     */
    public $deploy_data;

    /*
     * Verbose output.
     */
    public $debug = FALSE;

    /*
     * Used to collect logs,
     * (to be stored in records raw.)
     */
    public $log = array();

    /**
     * Get ready with all the data we need,
     * store deploy id,
     * store repo home
     * store modals
     * store deploy data
     * store user id
     * create folders (local folders).
     *
     * @param $id -> deploy id
     * @param $branch -> branch id
     */
    public function __construct($id) {
        // collect id.
        $this->deploy_id = $id;

        // Assign paths
        $this->repo_home = DOCROOT . 'fuel/repository';

        // collect models.
        $this->m_deploy = new Model_Deploy();
        $this->m_deploy->id = $this->deploy_id;
        $this->get_deploy_data();
        $this->user_id = $this->deploy_data['user_id'];
        $this->m_deploy->user_id = $this->user_id;
        $this->m_record = new Model_Record();
        $this->m_record->user_id = $this->user_id;
        $this->m_branches = new Model_Branch();
        $this->m_branches->user_id = $this->user_id;

        // collect data.
        $this->createFolders();
        chdir($this->repo_dir); // change to repo dir !!!. we are on repo dir forever.
        $this->output('Changed directory to ' . getcwd());
    }

    /**
     * Iterating function. (INIT FUNCTION)
     *
     * @throws Exception
     */
    public function deploy() {
        /*
         * Check if its currenly being deployed.
         * If active, die.
         */
        $is_active = $this->m_record->is_queue_active($this->deploy_id);
        if ($is_active) {
            die("The queue is already running.\n"); // not to move forward.
        }

        /*
         * Get a record from queue.
         */
        $this->record = $this->m_record->get_next_from_queue($this->deploy_id);
        if ($this->record == FALSE) {
            die("The queue is over.\n"); // not to move forward.
        }

        /*
         * Do not stop at errors. Instead throw exceptions.
         */
        $old_error_handler = set_error_handler(array(
            $this,
            'error_handler'
        ));

        $this->output('---------------------------------------------');
        $this->output('---------------------------------------------');
        $this->output('|            Magic code Starting            |');
        $this->output('---------------------------------------------');
        $this->output('---------------------------------------------');

        $this->log = array();
        $this->get_deploy_data();

        // This record is will be processed.
        $this->record_id = $this->record['id'];

        // Setting this record_id in progress.
        $this->m_record->set($this->record_id, array(
            'status' => $this->m_record->in_progress
        ));

        // WE ARE IN CHARGE OF THIS RECORDS SAFETY!
        $this->output('starting with record id: ' . $this->record_id);

        // CHILLING OUT FOR 1 SECOND.
        sleep(1);

        try {

            // Testing connection for safety.
            $branches = Utils::gitGetBranches($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);
            if ($branches == FALSE) {
                $this->log('Could not connect to repository.');
                throw new Exception('Failed to connect to repository');
            } else {
                $this->output('Fetched ' . count($branches) . ' branches');
                $this->log('repo_connect', 'Connection to ' . $this->deploy_data['repository'] . ' successful.');
            }

            // Getting branch data of the respective RECORD.
            $branch_id = $this->record['branch_id'];
            $branch = $this->m_branches->get_by_branch_id($branch_id);
            if (count($branch) !== 1) {
                throw new Exception('Branch does not exist.');
            } else {
                $this->branch = $branch[0];
            }

            if ($this->deploy_data['cloned']) {
                $this->output('Pulling repo');
                // pull only the given branch.
                $this->pullRepo($this->branch['branch_name']);
            } else {
                $this->output('Cloning repo');
                $this->cloneRepo();
            }

            // Okay, Start uploading the changed files.
            $this->upload();

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
             * IF SHIT GOES TO HELL. set record as failed.
             * And store logs.
             */
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log)
            ), TRUE);

            /*
             * pull and clone done,
             * checkout to branch now.
             */

            Utils::gitCommand('checkout master'); // failed? reset to master

            $this->output('DAMMIT. ' . $e->getMessage());
            // Lets iterate.
        }

        // NEXT!
        $this->deploy();
    }

    public function error_handler($errno, $errstr, $errfile, $errline) {
//        if (!(error_reporting() & $errno)) {
//            // This error code is not included in error_reporting
//            return;
//        }
//
//        switch ($errno) {
//            case E_USER_ERROR:
//                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
//                echo "  Fatal error on line $errline in file $errfile";
//                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
//                echo "Aborting...<br />\n";
//                exit(1);
//                break;
//
//            case E_USER_WARNING:
//                echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
//                break;
//
//            case E_USER_NOTICE:
//                echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
//                break;
//
//            default:
//                echo "Unknown error type: [$errno] $errstr<br />\n";
//                break;
//        }

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

        $m_ftp = new Model_Ftp();
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
            $ftp_test = new \bridge($ftp_url);
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
        Utils::gitCommand("checkout " . $this->branch['branch_name']);
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
            Utils::gitCommand('checkout ' . $this->record['hash']);
        }

        // if type_sync
        if ($this->record['record_type'] == $this->m_record->type_sync) {
            // upload all files please.
            $options['remoteRevision'] = '';
        }

        if ($this->record['record_type'] == $this->m_record->type_service_push) {
            // push from github/bitbucket.
            if (!empty($this->record['hash']))
                Utils::gitCommand('checkout ' . $this->record['hash']);
        }

        // else its update

        $localRevision = Utils::gitCommand('rev-parse HEAD');
        if (isset($localRevision[0])) {
            $localRevision = trim($localRevision[0]);
            $options['localRevision'] = $localRevision;
        }

        if ($options['localRevision'] == $options['remoteRevision']) {
            $this->output('FTP server has the latest changes!');
            $this->log('FTP server has the latest changes!');
        }

        $this->output($localRevision);

        $gitcore = new gitcore($options);
        try {
            $gitcore->startDeploy();
        } catch (Exception $e) {
            // Store logs from GITCORE.
            $this->log('deploy_log', $gitcore->log);
            $this->output($this->log);
            throw new Exception($e->getMessage());
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
        Utils::gitCommand('checkout master');

        // relax
        sleep(1);
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
        } catch (Exception $e) {
            $p = new Process('mkdir ' . $this->repo_home . '/' . $this->user_id);
            $p->run();
            $this->output('Created user folder: ' . $this->user_dir);
        }
        $this->user_dir = $this->repo_home . '/' . $this->user_id;

        // repo folder.
        try {
            \File::read_dir($this->user_dir . '/' . $this->deploy_id);
            \Cli::write('could read the file.');
        } catch (Exception $ex) {
            $p = new Process('mkdir ' . $this->user_dir . '/' . $this->deploy_id);
            $p->run();
            $this->output('Created repo folders: ' . $this->repo_dir);
        }
        $this->repo_dir = $this->user_dir . '/' . $this->deploy_id;
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
        // Repo is being cloned, set to working
        // 2 -> working
        // 1 -> success
        // 0 -> failed
        $this->m_deploy->set(NULL, array(
            'cloned' => 2
        ));

        // Clone the repository depth 1.
        exec('git clone ' . $this->deploy_data['repository'] . ' . --progress 2>&1', $gitOutput);
//        exec('git clone --depth 1 ' . $this->deploy_data['repository'] . ' . --progress 2>&1', $gitOutput);
        // Set branches to *
        exec("git remote set-branches origin '*'", $gitOutput);
        // Fetch all branches from remote
        exec('git fetch -vvv --progress 2>&1', $gitOutput);
        $this->output($gitOutput);

        /*
         * Try reading the Repo directory.
         */
        try {
            // read the directory.
            $dir_read = File::read_dir($this->repo_dir);
        } catch (Exception $ex) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Try reading the .git directory.
         */
        try {
            $gitfolder = File::read_dir($this->repo_dir . '/.git', 0);
        } catch (Exception $e) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check for content inside .git folder.
         */
        if (count($gitfolder) == 0) {
            $this->log['repo_processed'] = 'No';
            $this->m_deploy->set(NULL, array(
                'cloned' => FALSE,
            ));
            throw new Exception('Failed to clone repo: ' . $this->deploy_data['repository']);
        } else {
            $this->log['repo_processed'] = 'Yes';
            $this->m_deploy->set(NULL, array(
                'cloned' => TRUE,
            ));
        }

        $this->output('Clone OK.');
        // checked , OK.
    }

    /**
     * Pull the repo when its already cloned.
     */
    public function pullRepo($branchName) {
        // checkout to the branch which we have to pull.
        exec('git checkout ' . $branchName, $op);

        $this->output('Checkout to ' . $branchName);

        // pull all branches

        exec('git pull --all', $pullop);
        // fetch all brnaches
        exec('git fetch --all', $pullop);
        // reset all local files and make exact copy of remote
        exec('git reset --hard origin/' . $branchName, $pullop);

        /*
         * Go back to master.
         */
        if ($branchName !== 'master') {
            exec('git checkout master');
        }

        $this->output($pullop);
    }

    /**
     * Updates the deploy data.
     */
    public function get_deploy_data() {
        // Get data without user check,
        $deploy_data = $this->m_deploy->get(NULL, NULL, TRUE);
        if (count($deploy_data) !== 1) {
            throw new Exception("deploy doesnt exist.");
        } else {
            $this->deploy_data = $deploy_data[0];
        }
        // parse username and password to the repository's URL.
        $this->deploy_data['repository'] = $this->parseUsernamePassword($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);
        $this->output('Getting deploy data: ' . $this->deploy_data['repository']);
    }

    /**
     * Print on screen
     *
     * @param $message
     */
    public function output($message) {
        if ($this->debug)
            if (is_array($message)) {
                $message = print_r($message, TRUE);
            }
        Cli::write("~ $message");
    }

    /**
     * This function initiates the deploy in background process.
     * Using Fuelphp task runner.
     *
     * @return bool
     */
    public static function deploy_in_bg($deploy_id) {
        shell_exec('FUEL_ENV=' . \Fuel::$env . ' php /var/www/html/oil refine crontask:deploy ' . $deploy_id . ' > /dev/null 2>/dev/null &');

        return TRUE;
    }

    /**
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
}

/* end of file Gfcore.php */