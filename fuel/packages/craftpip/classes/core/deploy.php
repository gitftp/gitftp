<?php

class Deploy extends DeployHelper {

    public $user_id; // current user
    public $deploy_id; // current deploy
    public $record_id; // iterated record id. that changes
    public $record; // iterated record. that changes.
    public $branch; // iterated branch. that changes.
    public $record_type; // record type that changes

    public $repo_home; // repo home (fuel/repository)
    public $user_dir; // user directory.
    public $repo_dir; // repo directory.

    public $ftp_data; // ftp data . that changes.
    public $data; //An assoc array from DB of the currently being deployed data.
    public $debug = TRUE; // Verbose output in logs.

    public $m_deploy; // deploy modal
    public $m_record; // record modal
    public $m_branches; // branch modal
    public $m_ftp; // ftp modal

    public $log = array(); // Used to collect logs, (to be stored in records raw.)
    public $gitapi; // Git API helper class.
    public $is_cloned; // is the project cloned.

    public $localRevision;
    public $remoteRevision;
    public $writeOutputToLog = FALSE;
    public $attempt = 0;

    // deploy script
    public $globalFilesToIgnore = array(
        '.gitignore',
        '.gitmodules',
    );
    public $filesToIgnore = array();
    public $filesToInclude = array();
    public $scanSubmodules = FALSE;
    public $scanSubSubmodules = TRUE;
    public $submodules = array();
    public $purgeDirs = array();
    public $connection = FALSE;
    public $server = array();
    public $repo;
    public $mainRepo;
    public $currentSubmoduleName = FALSE;
    public $dotRevision;
    public $sync = FALSE;
    public $deploymentSize = 0;

    // END deploy script
    public function __construct($deploy_id) {
        if (is_debug)
            $this->writeOutputToLog = TRUE;
        $old_error_handler = set_error_handler(array( // Handle traditional errors. Instead throw & log exceptions.
            $this,
            'error_handler'
        ));
        $this->deploy_id = $deploy_id;
        $this->repo_home = DOCROOT . 'fuel/repository';
        $this->m_deploy = new \Model_Deploy();
        $this->m_deploy->id = $this->deploy_id;
        $this->data = $this->m_deploy->get(NULL, NULL, TRUE);
        if (count($this->data) !== 1) {
            logger(550, 'CORE: deploy doesnt exist: ' . $deploy_id, __METHOD__);
            throw new \Exception("Project id: $deploy_id does not exist.");
        } else {
            $this->data = $this->data[0];
        }

        $this->user_id = $this->data['user_id'];
        $this->createFolders(); // create necessary folders on disk.
        $this->m_deploy->user_id = $this->user_id;
        $this->m_record = new \Model_Record($this->user_id);
        $this->m_branches = new \Model_Branch($this->user_id);
        $this->m_ftp = new \Model_Ftp($this->user_id);
        $this->is_cloned = ($this->data['cloned'] == 1) ? TRUE : FALSE;
        $this->gitapi = new \Craftpip\GitApi($this->user_id); // get GIT API HELPER.

        // github or bitbucket.
        $this->provider = strtolower(\Utils::parseProviderFromRepository($this->data['repository'])); // get current provider

        try {
            chdir($this->repo_dir); // change to repo dir !!!. we are on repo dir forever. NO NEED TO CHANGE IT LATER.
        } catch (Exception $e) {
            logger(600, 'User & Repo dir not created: ' . $e->getMessage(), __METHOD__);
        }
        $this->output('Current directory: ' . getcwd());
        $this->repo = $this->repo_dir;
        $this->mainRepo = $this->repo_dir;
    }

    public function error_handler($errno, $errstr, $errfile, $errline) {
        /* Don't execute PHP internal error handler */
        // apparently those will break the deploys.
        logger(600, "An error was handled: $errstr File: $errfile Line: $errline", __METHOD__);
        throw new Exception($errstr, $errno);
    }

    // start deploy process.
    public function init() {
        // Check if its currenly being deployed. If active, die.
        $is_active = $this->m_record->is_queue_active($this->deploy_id);
        if ($is_active) {
            $this->output("The queue is already running.");
            die(); // not to move forward.
        }

        // Get a record from queue.
        $this->record = $this->m_record->get_next_from_queue($this->deploy_id);
        if ($this->record == FALSE) {
            $this->output("The queue is over.");
            die(); // not to move forward.
        }

        $this->output('-------------- initializing --------------');

        $this->log = array(); // empty it.
        $this->record_id = $this->record['id'];
        $this->record_type = $this->record['record_type'];
        $this->m_record->set($this->record_id, array(
            'status' => $this->m_record->in_progress // its in progress now.
        ));

        logger(550, 'Processing record ' . $this->record_id, __METHOD__);

        $this->output('Starting with record id: ' . $this->record_id);

        try {
            // check for connectivity to git service.
            try {
                $branches = \Utils::gitGetBranches2($this->clone_url());
            } catch (Exception $e) {
                $this->log('CORE: Error, ' . $e->getMessage() . ', could not connect to repository');
                throw $e;
            }

            $this->output(is_array($branches) ? 'found branches ' . implode(', ', $branches) : 'no branches found.'); // no branches found ? that shouldnt happen.
            $this->output('Fetched ' . count($branches) . ' branches');
            $this->log('CORE: Connected to ' . $this->data['repository'] . '.');

            if ($this->record_type == $this->m_record->type_first_clone) {
                if (!$this->is_cloned) {
                    $this->output('Cloning repo');
                    $this->cloneRepoLoop();
                } else {
                    $this->output('Pulling repo');
                    $this->pullRepo();
                }
            } else {
                // getting branch data.
                $branch_id = $this->record['branch_id'];
                $branch = $this->m_branches->get_by_branch_id($branch_id);
                if (count($branch) !== 1) {
                    logger(300, 'CORE: ENV NOT FOUND.' . $branch_id, __METHOD__);
                    $this->log('ENV: ERROR 10004: Environment was not found');
                    throw new Exception('Branch/Environment not found.');
                } else {
                    $this->branch = $branch[0];
                }

                if (!$this->is_cloned) {
                    $this->output('Cloning repo');
                    $this->cloneRepoLoop();
                } else {
                    $this->output('Pulling repo');
                    $this->pullRepo($this->branch['branch_name']);
                }

                $this->initUpload();

                // done with branch.

                $this->m_record->set($this->record_id, array(
                    'raw' => serialize($this->log)
                ), TRUE);
                $this->m_branches->set($this->record['branch_id'], array(
                    'revision' => $this->localRevision,
                    'ready'    => 1
                ), TRUE);
            }

            // DONE.
            $this->output('Success with record id: ' . $this->record_id);
            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->success
            ), TRUE);

        } catch (Exception $e) {
            logger(550, "CORE $this->deploy_id ERROR: " . $e->getMessage(), __METHOD__);
            $error = $e->getCode() . ' ' . $e->getMessage();
            if (is_debug)
                $error .= ' <br>Trace: ' . $e->getTraceAsString();
            $this->log('ERROR', $error);

            $this->m_record->set($this->record_id, array(
                'status' => $this->m_record->failed,
                'raw'    => serialize($this->log)
            ), TRUE);

            $this->output('DAMMIT!, ' . $e->getMessage(), 'white', 'red');
        }

        if ($this->is_cloned)
            $this->gitCommand('checkout master');

        // Looping here.
        $this->init();
    }

    public function pullRepo($branchName = NULL) { // optionally pull a specific branch
        $this->gitCommand('remote set-url origin ' . $this->clone_url()); // update clone url to put in new access token.

        if (is_null($branchName)) {
            $this->gitCommand('pull --all');
            $this->gitCommand('fetch --all');
        } else {
            $this->gitCommand('checkout ' . $branchName);
            $this->output('checkout to ' . $branchName);
            $this->gitCommand('pull --all');
            $this->gitCommand('fetch --all');
            $this->gitCommand('reset --hard origin/' . $branchName);

            if ($branchName !== 'master') {
                $this->gitCommand('checkout master');
            }
        }
    }

    public function cloneRepoLoop() {
        $this->m_deploy->set(NULL, array(
            'cloned' => $this->m_deploy->clone_working
        ));

        $this->attempt = 0;
        while (!$this->cloneRepo()) {
            $this->output('Clone attempt: ' . $this->attempt);
            $this->attempt += 1;
            if ($this->attempt == 5) {
                $this->log('CORE: Error 10002: Could not connect: ' . $this->deploy_data['repository']);
                $this->m_deploy->set(NULL, array(
                    'cloned' => FALSE,
                ));

                throw new \Exception('Could not connect to repository.');
            }
        }

        $this->log('repo_processed', 'Yes');
        $this->m_deploy->set(NULL, array(
            'cloned' => TRUE,
        ));
        $this->is_cloned = TRUE;
        $this->output('Clone ok.');
    }

    public function cloneRepo() {
        $dir = $this->runCommand('ls -a');
        if (count($dir)) {
            $dir = array_flip($dir);
            $this->runCommand('rm -rf ./.*', FALSE); // remove .git folder.
            $this->runCommand('rm -rf *', FALSE); // remove all files recursively.
        }
        // clone in current dir.
        $this->runCommand('git clone ' . $this->clone_url() . ' .');
        // Set branches to *
        $this->gitCommand("remote set-branches origin '*'", FALSE);
        // Fetch all branches from remote
        $this->gitCommand('fetch -vvv --progress 2>&1', FALSE);

        // check if .git exists. if exists all okay.
        $dir = $this->runCommand('ls -a');
        $gitdir = $this->runCommand('ls .git -a');
        $dir = array_flip($dir);

        if (!array_key_exists('.git', $dir) || count($gitdir) == 0) {
            return FALSE;
        }

        return TRUE;
    }

    public function testFtpConnection() {
        try {
            print_r($this->ftp_data);
            $this->ftp_data['user'] = $this->ftp_data['username'];
            $ftp_url = http_build_url($this->ftp_data);
            $this->output($ftp_url);
            $ftp_test = new \bridge($ftp_url);
            if ($ftp_test) {
                return TRUE;
            }

            return FALSE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function initUpload() {
        // FYI. We are on master now.

        $this->ftp_data = $this->m_ftp->get($this->branch['ftp_id']);
        if (count($this->ftp_data) == 0) {
            $this->log('ENV: Error 10005: Envionrment does not have a linked FTP account.');
            throw new Exception('No linked ftp account');
        } else {
            $this->ftp_data = $this->ftp_data[0];
        }

        // testing connection to ftp server.
        $this->attempt = 1;
        while (!$this->testFtpConnection()) {
            $this->output('FTP connection attempt: ' . $this->attempt);
            $this->attempt += 1;
            if ($this->attempt == 5) {
                $this->log('FTP: Error 10006: Could not connect to FTP server at 5 attempts.');
                throw new Exception('Could not connect to FTP server');
            }
        }

        $this->log('FTP: Connected to ftp server on ' . $this->attempt . ' attempt(s).');
        $this->log('ENV: enviornment: ' . $this->branch['name']);
        $this->log('ENV: branch name: ' . $this->branch['branch_name']);

        // lets checkout the required branch.
        $this->gitCommand('checkout ' . $this->branch['branch_name']);
        $this->log('ENV: Revision on remote server: ' . $this->branch['revision']);

        // set remote
        $this->remoteRevision = $this->branch['revision'];
        $this->m_record->set($this->record_id, array(
            'hash_before' => $this->remoteRevision
        ), TRUE);

        if ($this->record_type == $this->m_record->type_rollback && !empty($this->record['hash'])) {
            $this->gitCommand('checkout ' . $this->record['hash']);
        }

        if ($this->record_type == $this->m_record->type_service_push && !empty($this->record['hash'])) {
            $this->gitCommand('checkout ' . $this->record['hash']);
        }

        if ($this->record_type == $this->m_record->type_sync) {
            $this->remoteRevision = ''; // upload all files..
        }

        if ($this->record_type == $this->m_record->type_update) {
            // will compare against $this->branch['revision']
        }

        $this->localRevision = $this->gitCommand('rev-parse HEAD'); // where is the HEAD.

        if (count($this->localRevision))
            $this->localRevision = trim($this->localRevision[0]);
        else
            $this->localRevision = '';

        if ($this->localRevision == '')
            logger(600, 'Local revision is null. Repository is not cloned but ready.', __METHOD__);
        // this happened once.

        if ($this->localRevision == $this->remoteRevision)
            $this->log('ENV: Remote server has latest changes');

        $this->log('ENV: Updating remote server at: ' . $this->localRevision);

        $this->m_record->set($this->record_id, array(
            'hash' => $this->localRevision,
        ), TRUE);

        $this->scanSubmodules = TRUE;
        $this->scanSubSubmodules = FALSE;

        $this->checkSubmodules($this->repo_dir);
        $this->deploy();
    }

    public function deploy() {
        $revision = $this->localRevision;
        $this->prepareServer();
        $this->connect();
        $this->log('FTP: Connected to ftp server.');
        $files = $this->compare();
        $this->push($files);

        if (isset($this->purgeDirs) && count($this->purgeDirs) > 0) {
            $this->purge($this->purgeDirs);
        }

        if ($this->scanSubmodules && count($this->submodules) > 0) {
            foreach ($this->submodules as $submodule) {
                $this->repo = $submodule['path'];
                $this->currentSubmoduleName = $submodule['name'];
                $this->output("SUBMODULE: " . $this->currentSubmoduleName);
                $files = $this->compare($revision);
                $this->push($files);
            }
            // We've finished deploying submodules, reset settings for the next server
            $this->repo = $this->mainRepo;
            $this->currentSubmoduleName = FALSE;
        }

        // Done.
//        $this->log('CORE: deployed ' . \Num::format_bytes($this->deploymentSize, 2));
        $formatedBytes = \Num::format_bytes($this->deploymentSize, 2);
        $this->log('CORE: Deployed ' . $this->deploymentSize . ' Bytes');
        $this->output($formatedBytes . " Deployed");
        $this->m_record->set($this->record_id, array(
            'amount_deployed_raw' => $this->deploymentSize,
            'amount_deployed'     => $formatedBytes == 0 ? '0 B' : $formatedBytes,
        ), TRUE); // set deployed amount.

        $this->deploymentSize = 0;
    }

    public function push($files) {
        $initialBranch = $this->currentBranch();
        $filesToDelete = $files['delete'];
        $dirsToDelete = [];
        if (count($filesToDelete) > 0) {
            $dirsToDelete = $this->hasDeletedDirectories($filesToDelete);
        }
        $filesToUpload = $files['upload'];
        unset($files);

        // total files
        $this->output('Starting to make changes on server');

        $totalcount = count($filesToDelete) + count($filesToUpload);
        $this->m_record->set($this->record_id, array(
            'total_files' => (int)$totalcount,
        ), TRUE);
        $currentFile = 0;

        $this->output('Total files to process, ' . $totalcount);
        $this->log('CORE: Gathered ' . $totalcount . ' changed files.');

        // Delete files
        if (count($filesToDelete) > 0) {
            foreach ($filesToDelete as $fileNo => $file) {
                $numberOfFilesToDelete = count($filesToDelete);
                try {
                    $this->connection->rm($file);
                    $this->output("× $fileNo of $numberOfFilesToDelete {$file}");
                } catch (Exception $e) {
                    $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToDelete), ' ', STR_PAD_LEFT);
                    $this->output("! $fileNo of $numberOfFilesToDelete {$file} not found");
                    $this->log("CORE: Warning: could not delete {$file}.");
                }

                $currentFile += 1; // incremented.
                if ($currentFile % 5 == 0 || $currentFile == $totalcount) { // update in database after 5 files.
                    $this->m_record->set($this->record_id, array(
                        'processed_files' => $currentFile
                    ), TRUE);
                }
            }
        }

        // Delete Directories
        if (count($dirsToDelete) > 0) {
            foreach ($dirsToDelete as $dirNo => $dir) {
                $numberOfdirsToDelete = count($dirsToDelete);
                try {
                    if (\Str::starts_with($dir, '/'))
                        $dir = preg_replace('/^(\/+)/', '', $dir);

                    $this->connection->rmdir($dir);
                } catch (Exception $e) {
                    $this->log("CORE: Warning: Could not remove directory $dir - $e->getMessage()");
                }
                $dirNo = str_pad(++$dirNo, strlen($numberOfdirsToDelete), ' ', STR_PAD_LEFT);
                $this->output("× $dirNo of $numberOfdirsToDelete {$dir}");
            }
        }

        // Upload Files
        if (count($filesToUpload) > 0) {
            foreach ($filesToUpload as $fileNo => $file) {
                if ($this->currentSubmoduleName) {
                    $file = $this->currentSubmoduleName . '/' . $file;
                }

                // Make sure the folder exists in the FTP server.
                $dir = explode("/", dirname($file));
                $path = "";
                $ret = TRUE;

                // Skip mkdir if dir is basedir
                if ($dir[0] !== '.') {
                    // Loop through each folder in the path /a/b/c/d.txt to ensure that it exists
                    for ($i = 0, $count = count($dir); $i < $count; $i++) {
                        $path .= $dir[$i] . '/';

                        if (!isset($pathsThatExist[$path])) {
                            $origin = $this->connection->pwd();

                            if (!$this->connection->exists($path)) {
                                try {
                                    $this->connection->mkdir($path);
                                } catch (Exception $e) {
                                    $this->log('CORE: Could not create dir ' . $path);
                                    throw new \Exception('Could not create directory');
                                }
                                $this->output("Created directory '$path'.");
                                $pathsThatExist[$path] = TRUE;
                            } else {
                                $this->connection->cd($path);
                                $pathsThatExist[$path] = TRUE;
                            }

                            // Go home
                            $this->connection->cd($origin);
                        }
                    }
                }

                // Now upload the file, attempting 10 times
                // before exiting with a failure message
                $uploaded = FALSE;
                $attempts = 1;
                while (!$uploaded) {
                    if ($attempts == 5) {
                        throw new \Exception("Tried to upload $file 5 times and failed. Something is wrong...");
                    }

                    $data = file_get_contents($this->repo . '/' . $file);
                    $this->output($this->repo . '/' . $file);
                    $remoteFile = $file;

                    try {
                        $uploaded = $this->connection->put($data, $remoteFile);
                    } catch (Exception $e) {
                        $uploaded = FALSE;
                    }

                    if (!$uploaded) {
                        $attempts = $attempts + 1;
                        $this->output("Failed to upload {$file}. Retrying (attempt $attempts/10)...");
                        $this->log("Failed to upload {$file}. Retrying (attempt $attempts/10)...");
                    } else {
                        $this->deploymentSize += filesize($this->repo . '/' . $file);

                        $currentFile += 1; // incremented.
                        if ($currentFile % 5 == 0 || $currentFile == $totalcount) { // update in database after 5 files.
                            $this->m_record->set($this->record_id, array(
                                'processed_files' => $currentFile
                            ), TRUE);
                        }
                    }
                }

                $numberOfFilesToUpdate = count($filesToUpload);
                $this->output("^ $fileNo of $numberOfFilesToUpdate {$file}");
            }
        }

        // If $this->revision is not HEAD, it means the rollback command was provided
        // The working copy was rolled back earlier to run the deployment, and we now want to return the working copy
        // back to its original state
//        if ($this->revision != 'HEAD') {
//            $this->gitCommand('checkout ' . ($initialBranch ?: 'master'));
//        }
    }

    public function compare() {
        $tmpFile = tmpfile();
        $remoteRevision = $this->remoteRevision;
        $localRevision = $this->localRevision;
        $filesToUpload = array();
        $filesToDelete = array();
        $filesToSkip = array();
        $output = array();

        if (empty($remoteRevision)) {
            $command = '-c core.quotepath=false ls-files';
        } else {
            $command = '-c core.quotepath=false diff --name-status ' . $remoteRevision . ' ' . $localRevision;
        }

        $output = $this->gitCommand($command);

        /**
         * Git Status Codes
         *
         * A: addition of a file
         * C: copy of a file into a new one
         * D: deletion of a file
         * M: modification of the contents or mode of a file
         * R: renaming of a file
         * T: change in the type of the file
         * U: file is unmerged (you must complete the merge before it can be committed)
         * X: "unknown" change type (most probably a bug, please report it)
         */

        if (!empty($remoteRevision)) {
            foreach ($output as $line) {
                if ($line[0] === 'A' or $line[0] === 'C' or $line[0] === 'M' or $line[0] === 'T') {
                    $filesToUpload[] = trim(substr($line, 1));
                } elseif ($line[0] == 'D' or $line[0] === 'T') {
                    $filesToDelete[] = trim(substr($line, 1));
                } else {
                    throw new \Exception("Unsupported git-diff status: {$line[0]}");
                }
            }
        } else {
            $filesToUpload = $output;
        }

        $filteredFilesToUpload = $this->filterIgnoredFiles($filesToUpload);
        $filteredFilesToDelete = $this->filterIgnoredFiles($filesToDelete);

        $filesToDelete = $filteredFilesToDelete['files'];
        $filesToUpload = $filteredFilesToUpload['files'];
        $filesToSkip = array_merge($filteredFilesToDelete['filesToSkip'], $filteredFilesToUpload['filesToSkip']);
        $this->m_record->set($this->record_id, array(
            'file_add'    => count($filesToUpload),
            'file_remove' => count($filesToDelete),
            'file_skip'   => count($filesToSkip),
        ), TRUE);
        $this->log('CORE: Files modified/added: ' . count($filesToUpload));
        $this->log('CORE: Files deleted/renamed: ' . count($filesToDelete));
        $this->log('CORE: Files Skipped: ' . count($filesToSkip));

        return array(
            'delete' => $filesToDelete,
            'upload' => $filesToUpload,
            'skip'   => $filesToSkip,
        );
    }

    public function prepareServer() {
        $defaults = array(
            'scheme'  => 'ftp',
            'host'    => '',
            'user'    => '',
            'pass'    => '',
            'pubkey'  => '',
            'privkey' => '',
            'keypass' => '',
            'port'    => '',
            'path'    => '/',
            'passive' => TRUE,
            'skip'    => array(),
            'purge'   => array(),
            'include' => array()
        );

        $options = array_merge($defaults, $this->ftp_data);
        $this->filesToIgnore = $this->globalFilesToIgnore;
        $this->filesToIgnore = array_merge($this->filesToIgnore, $this->branch['skip_path']);
        if (!empty($this->branch['include_path'])) {
            $this->filesToInclude = $this->branch['include_path'];
        } else {
            $this->filesToInclude = array('*');
        }
        $this->purgeDirs = $this->branch['purge_path'];

        if ($options['pass'] == '') {
            $this->log('FTP: FTP does not have a password');
        }

        $bridgeOptions = array();

        // here.
        if ($options['pubkey'] != '' || $options['privkey'] != '') {
            // in future.
            $key = array(
                'pubkeyfile'  => FALSE,
                'privkeyfile' => FALSE,
                'user'        => $options['user'],
                'passphrase'  => FALSE
            );

            if ($options['pubkey'] == '' || !is_readable($options['pubkey'])) {
                throw new \Exception("Cannot read SSH public key file: {$options['pubkey']}");
            }
            $key['pubkeyfile'] = $options['pubkey'];

            if ($options['privkey'] == '' || !is_readable($options['privkey'])) {
                throw new \Exception("Cannot read SSH private key file: {$options['pubkey']}");
            }
            $key['privkeyfile'] = $options['privkey'];

            if ($options['keypass'] !== '') {
                $key['passphrase'] = $options['keypass'];
            }

            $bridgeOptions['pubkey'] = $key;
        }

        $this->server = array(
            'url'     => http_build_url('', $options), // Turn options into an URL so that Bridge can work with it.
            'options' => $bridgeOptions
        );
    }

    public function connect() {
        try {
            $connection = new \Banago\Bridge\Bridge($this->server['url'], $this->server['options']);
            $this->connection = $connection;
        } catch (Exception $e) {
            $this->log('FTP: Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function checkSubmodules($repo) {
        if ($this->scanSubmodules) {
            $this->output('Scanning repository...');
        }

        $output = $this->gitCommand('submodule status', $this->repo_dir);

        if ($this->scanSubmodules) {
            $this->output('   Found ' . count($output) . ' submodules.');
        }

        // todo: not working with it yet.
        if (count($output) > 0) {
            foreach ($output as $line) {
                $line = explode(' ', trim($line));

                // If submodules are turned off, don't add them to queue
                if ($this->scanSubmodules) {
                    $this->submodules[] = array('revision' => $line[0], 'name' => $line[1], 'path' => $repo . '/' . $line[1]);
                    $this->output(sprintf('   Found submodule %s. %s',
                        $line[1],
                        $this->scanSubSubmodules ? PHP_EOL . '      Scanning for sub-submodules...' : NULL
                    ));
                }

                $this->globalFilesToIgnore[] = $line[1];

                $this->checkSubSubmodules($repo, $line[1]);
            }
            if (!$this->scanSubSubmodules) {
                $this->output('   Skipping search for sub-submodules.');
            }
        }
    }

}