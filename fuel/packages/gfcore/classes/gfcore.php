<?php

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
     * Gfcore collects and stores data about the deploy to process its queue.
     */

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
     * Gives verbose output.
     */
    public $debug = TRUE;

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
    }

    /**
     * Updates the deploy data.
     */
    public function get_deploy_data() {
        // Get data without user check,
        $this->deploy_data = $this->m_deploy->get(NULL, NULL, TRUE)[0];
        // parse username and password to the repository's URL.
        $this->deploy_data['repository'] = $this->parseUsernamePassword($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);
    }

    /**
     * Initialization function.
     *
     * @throws Exception
     */
    public function deploy() {
        // This is the deploy loop.
        // change dir to repo dir.
        chdir($this->repo_dir);

        // check if to continue deploy,
        // if $is_active is true, we do not have to continue with the deploy.
        // (because its already being deployed and in iteration process)
        $is_active = $this->m_record->is_queue_active($this->deploy_id);

        if ($is_active) {
            // if the deploy is active, DO NOT MOVE AHEAD.
            // if the deploy has no queue, DO NOT MOVE AHEAD. I repeat, Captain.

            throw new Exception('The queue is already in process.');
        }

        // The queue is not active, and we have to iterate it!.

        // individual logs for each records.
        $this->log = array();

        // updating new data. (to get if to clone or pull)
        $this->get_deploy_data();

        // Getting the first record to process, if false is returned (The queue is over)
        $this->record = $this->m_record->get_next_from_queue($this->deploy_id);

        if ($this->record == FALSE) {
            // stop iterating, the queue is done.
            echo 'The queue is over, Done!';

            return;
        }

        // Store record_id that is to be processed.
        $this->record_id = $this->record['id'];

        echo 'Processing ' . $this->record_id;

        // On your mark! setting the record in progress,
        $this->m_record->set($this->record_id, array(
            'status' => $this->m_record->in_progress
        ));

        // Chilling.
        sleep(1);

        try {

            // checking connection to git.
            $branches = utils::gitGetBranches($this->deploy_data['repository'], $this->deploy_data['username'], $this->deploy_data['password']);

            if ($branches == FALSE) {
                // $branches will be false, if there is some problem with the repository, else always HEAD will be returned in array.
                $this->log['connection'] = 'Could not connect to repository: ' . $this->deploy_data['repository'];

                // stop execution and mark as failed.
                throw new Exception('');

            } else {
                $this->log['connection'] = 'connected to repository: ' . $this->deploy_data['repository'];
            }

            if ($this->deploy_data['cloned']) {
                if ($this->debug)
                    $this->log['action'] = 'pull';
                $this->pullRepo();
            } else {
                if ($this->debug)
                    $this->log['action'] = 'clone';
                $this->cloneRepo();
            }

            // ok, start uploading the changed files.
            $this->upload();

            // all ok, set to success and move on.
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->success
            ), TRUE);

            // deployed!, the branch is ready.
            $this->m_branches->set($this->record['branch_id'], array(
                'ready' => 1
            ), TRUE);

            // Lets iterate.
            $this->deploy();

        } catch (Exception $e) {
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log)
            ), TRUE);
            // deploy failed because of something, logs are stored in raw.

            // Lets iterate.
            $this->deploy();
        }

    }

    /**
     * Upload module.
     * Compares files, and uploads them to the FTP server.
     *
     * @throws Exception
     */
    public function upload() {
        // Get the ftp modal.
        $m_ftp = new Model_Ftp();
        $m_ftp->user_id = $this->user_id;

        // Currently deploying branch.
        $branch_id = $this->record['branch_id'];

        // Get its branch data.
        $branch = $this->m_branches->get_by_branch_id($branch_id)[0]; // this is the branch to deploy from.

        // Get Ftp data from Branch
        $ftp_data = $m_ftp->get($branch['ftp_id'])[0];

        // Testing if the FTP server works.
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

        // branch name
        $this->log['deploy_branch'] = $branch['branch_name'];
        // env name
        $this->log['deploy_branch_env'] = $branch['name'];
        // Checkout to branch
        exec('git checkout ' . $branch['branch_name'], $checkCheckoutOp);

        if ($this->debug)
            $this->log['switching_to_branch_op'] = $checkCheckoutOp;

        $this->log['revision_on_server_before'] = $branch['revision'];

        // Prepare the GIT CORE.
        // Supply it with all the arguments it needs,
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
            // Diff files and Upload modified files.
            $gitcore->startDeploy();
        } catch (Exception $e) {

            // Store logs from GITCORE.
            $this->log['deploy_log'] = $gitcore->log;
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log),
            ));
            throw new Exception('Something went wrong while deployment. taken care of.');

        }

        // Store Logs from GITCORE.
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

        // Revision on server before deploy.
        $before_revision = $this->log['deploy_log']['gitftpop']['revision_before'];
        // Revision on server after deploy.
        $current_revision = $this->log['deploy_log']['gitftpop']['revision'];
        $this->log['revision_on_server_after'] = $current_revision;

        // Storing output from GITCORE.
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

        // OK,
        // Update branch to ready,
        // Update branch revision.
        $this->m_branches->set($branch['id'], array(
            'ready'    => 1,
            'revision' => $current_revision
        ));

        // OK, checkout to master.
        exec('git checkout master');
        sleep(1);

        // OK, deploy(project) is ready and deployed
        $this->m_deploy->set(NULL, array(
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

        // Repo is being cloned, set to working
        // 2 -> working
        // 1 -> success
        // 0 -> failed
        $this->m_deploy->set(NULL, array(
            'cloned' => 2
        ));

        // Clone the repository depth 1.
        exec('git clone --depth 1 ' . $this->deploy_data['repository'] . ' ' . $this->deploy_data['id'] . ' --progress 2>&1', $gitOutput);

        // Repo dir is ready
        chdir($this->repo_dir);

        // Set branches to *
        exec("git remote set-branches origin '*'", $gitOutput);

        // Fetch all branches from remote
        exec('git fetch -vvv --progress 2>&1', $gitOutput);

        // Checkout to master
        exec('git checkout master', $gitOutput);


        if ($this->debug)
            $this->log['repo_output'] = $gitOutput;

        /*
         * Try reading the Repo directory.
         */

        try {
            // read the directory.
            $dir_read = File::read_dir($this->repo_dir);
        } catch (Exception $ex) {
            $this->log['repo_failed'] = 'Could not connect to repository: <br>URL: ' . $this->deploy_data['repository'];
            $this->m_deploy->set(NULL, array(
                'cloned'   => FALSE,
                'deployed' => FALSE
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
                'cloned'   => FALSE,
                'deployed' => FALSE
            ));
            throw new Exception('The folder could not be read, please try again later.');
        }

        /*
         * Check for content inside .git folder.
         */
        if (count($gitfolder) == 0) {
            $this->log['repo_processed'] = 'No';
            $this->m_deploy->set(NULL, array(
                'cloned'   => FALSE,
                'deployed' => FALSE
            ));
            throw new Exception('Failed to clone repo: ' . $this->deploy_data['repository']);
        } else {
            $this->log['repo_processed'] = 'Yes';
            $this->m_deploy->set(NULL, array(
                'cloned'   => TRUE,
                'deployed' => FALSE
            ));
        }

        // checked , OK.
    }

    /**
     * Pull the repo when its already cloned.
     */
    public function pullRepo() {
        // Change to repo dir,
        chdir($this->repo_dir);

        if ($this->debug)
            $this->log['pull_working'] = 'Pulling repo';

        // pull repo rebase
        exec('git pull --rebase', $pullop);
        // fetch all
        exec('git fetch --all', $pullop);
        // reset all local files and make exact copy of remote
        exec('git reset --hard origin/master', $pullop);

        if ($this->debug)
            $this->log['pull_op'] = $pullop;

    }

    /**
     * This function initiates the deploy in background process.
     * Using Fuelphp task runner.
     *
     * @return bool
     */
    public static function deploy_in_bg($deploy_id) {
        shell_exec('php /var/www/html/oil refine crontask:deploy ' . $deploy_id . ' > /dev/null 2>/dev/null &');
        return TRUE;
    }
}

/* end of file Gfcore.php */