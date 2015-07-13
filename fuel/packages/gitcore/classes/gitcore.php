<?php

/**
 * Gitcore Class
 */
class gitcore {

    /**
     * @var string $phployVersion
     */
    protected $phployVersion = '3.1.0-stable';

    /**
     * @var string $revision
     */
    public $revision;

    /**
     * @var string $localRevision
     */
    public $localRevision;

    /**
     * Keep track of which server we are currently deploying to
     *
     * @var string $currentlyDeploying
     */
    public $currentlyDeploying = '';

    /**
     * A list of files that should NOT be uploaded to the remote server
     *
     * @var array $filesToIgnore
     */
    public $filesToIgnore = array();

    /**
     * A list of files that should NOT be uploaded to the any defined server
     *
     * @var array $globalFilesToIgnore
     */
    public $globalFilesToIgnore = array(
        '.gitignore',
        '.gitmodules',
    );

    /**
     * To activate submodule deployment use the --submodules argument
     *
     * @var bool $scanSubmodules
     */
    public $scanSubmodules = FALSE;

    /**
     * If you need support for sub-submodules, ensure this is set to TRUE
     * Set to false when the --skip-subsubmodules command line option is used
     *
     * @var bool $scanSubSubmodules
     */
    public $scanSubSubmodules = TRUE;

    /**
     * @var array $servers
     */
    public $servers = array();

    /**
     * @var array $submodules
     */
    public $submodules = array();


    /**
     * @var array $purgeDirs
     */
    public $purgeDirs = array();

    /**
     * The name of the file on remote servers that stores the current revision hash
     *
     * @var string $dotRevisionFilename
     */
    public $dotRevisionFilename = '.revision';

    /**
     * The filename from which to read remote server details
     *
     * @var string $deplyIniFilename
     */
    public $iniFilename = 'deploy.ini';

    /**
     * List of available "short" command line options, prefixed by a single hyphen
     * Colon suffix indicates that the option requires a value
     * Double-colon suffix indicates that the option *may* accept a value
     * See descriptions below
     *
     * @var string $shortops
     */
    protected $shortopts = 'los:';

    /**
     * List of available "long" command line options, prefixed by double-hyphen
     * Colon suffix indicates that the option requires a value
     * Double-colon suffix indicates that the option *may* accept a value
     *
     *      --help or -?                      Displays command line options
     *      --list or -l                      Lists the files that *would* be deployed if run without this option
     *      --rollback                        Deploys the previous commit/revision
     *      --rollback="[revision hash]"      Deploys the specific commit/revision
     *      --server="[server name]"          Deploys to the server entry listed in deploy.ini
     *        or -s [server name]
     *      --sync                            Updates the remote .revision file with the hash of the current HEAD
     *      --sync="[revision hash]"          Updates the remove .revision file with the provided hash
     *      --submodules                      Deploy submodules; turned off by default
     *      --skip-subsubmodules              Skips the scanning of sub-submodules which is currently quite slow
     *      --others                          Uploads files even if they are excluded in .gitignore
     *      --debug                           Displays extra messages including git and FTP commands
     *      --all                             Deploys to all configured servers (unless one was specified in the command line)
     *
     * @var array $longopts
     */
    protected $longopts = array('no-colors', 'help', 'list', 'rollback::', 'server:', 'sync::', 'submodules', 'skip-subsubmodules', 'others', 'debug', 'version', 'all');

    /**
     * @var bool|resource $connection
     */
    protected $connection = FALSE;

    /**
     * @var string $server
     */
    protected $server = '';

    /**
     * @var string $repo
     */
    protected $repo;

    /**
     * @var string $mainRepo
     */
    protected $mainRepo;

    /**
     * @var bool|string $currentSubmoduleName
     */
    protected $currentSubmoduleName = FALSE;

    /**
     * Holds the path to the .revision file
     * For the main repository this will be the value of $dotRevisionFilename ('.revision' by default)
     * but for submodules, the submodule path will be prepended
     *
     * @var string $dotRevision
     */
    protected $dotRevision;

    /**
     * Path to the directory on the server side where to store main $dotRevision file.
     */
    protected $dotRevisionDir = '';

    /**
     * Whether phploy is running in list mode (--list or -l commands)
     * @var bool $listFiles
     */
    protected $listFiles = FALSE;

    /**
     * Whether the --sync command line option was given
     * @var bool $sync
     */
    protected $sync = FALSE;

    /**
     * Whether phploy should ignore .gitignore (--others or -o commands)
     * @var bool $others
     */
    protected $others = FALSE;

    /**
     * Whether to print extra debugging info to the console, especially for git & FTP commands
     * Activated using --debug command line option
     * @var bool $debug
     */
    protected $debug = TRUE;

    /**
     * Keep track of current deployment size
     * @var int $deploymentSize
     */
    protected $deploymentSize = 0;

    /**
     * Keep track of if a default server has been configured
     * @var bool $defaultServer
     */
    protected $defaultServer = FALSE;

    /**
     * Weather the --all command line option was given
     * @var bool deployAll
     */
    protected $deployAll = FALSE;

    /**
     * CP: Maintain LOG
     */
    public $log = array();

    /**
     * CP: Options passed in
     */
    public $options;

    /**
     * Constructor
     */
    public function __construct($options) {
        /*
         * Options is passed from the constructor instead from commandline.
         */
        $this->parseOptions($options);

        // Chdir is once done in gfcore.
        // Here once again.
        chdir($this->repo);
    }

    public function startDeploy() {
        $this->log('Initializing deploy');

        if (file_exists("$this->repo/.git")) {

            // TODO: list files action. LATER.
            if ($this->listFiles) {
                $this->log("Listing files. but why?");
            }
            $this->checkSubmodules($this->repo);

            if ($this->revision === 'HEAD') {
                // Todo: pass hash instead of HEAD.

            }
            $this->deploy($this->revision);

        } else {

            $this->log('error', 'ERROR 404. Not a git repository.');
            throw new \Exception("'{$this->repo}' is not Git repository.");
        }

    }

    /**
     * Get current revision
     *
     * @return string with current revision hash
     */
    public function currentRevision() {
        $currentRevision = $this->gitCommand('rev-parse HEAD');

        return $currentRevision[0];
    }

    /**
     * CP: parse $options provided.
     *
     * Parse CLI options
     * For descriptions of the various options, see the comments for $this->longopts
     *
     * @return null
     */
    public function parseOptions($options) {

        $this->options = $options;

        $this->output('Command line options detected.');
        $this->output($options);

        if (isset($options['debug'])) {
            $this->debug = TRUE;
        }

        if (isset($options['version'])) {
            $this->displayVersion = TRUE;
        }

        if (isset($options['l']) or isset($options['list'])) {
            $this->listFiles = TRUE;
        }

        if (isset($options['s']) or isset($options['server'])) {
            $this->server = isset($options['s']) ? $options['s'] : $options['server'];
        }

        if (isset($options['o']) or isset($options['others'])) {
            $this->others = TRUE;
        }

        if (isset($options['sync'])) {
            $this->sync = empty($options['sync']) ? 'sync' : $options['sync'];
        }

        if (isset($options['rollback'])) {
            $this->revision = ($options['rollback'] == '') ? 'HEAD^' : $options['rollback'];
        } else {
            $this->revision = 'HEAD';
        }

        if (isset($options['submodules'])) {
            $this->scanSubmodules = TRUE;
        }

        if (isset($options['skip-subsubmodules'])) {
            $this->scanSubSubmodules = FALSE;
        }

        if (isset($options['all'])) {
            $this->deployAll = TRUE;
        }

        $this->repo = $options['repo'];
        $this->mainRepo = $this->repo;
    }

    /**
     * Check for submodules
     *
     * @param string $repo
     * @return null
     */
    public function checkSubmodules($repo) {
        if ($this->scanSubmodules) {
            $this->output('Scanning repository...');
        }

        $output = $this->gitCommand('submodule status', $repo);

        if ($this->scanSubmodules) {
            $this->output('   Found ' . count($output) . ' submodules.');
        }

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

    /**
     * Check for sub-submodules
     *
     * @todo This function is quite slow (at least on Windows it often takes several seconds for each call).
     *       Can it be optimized?
     *       It appears that this is called for EACH submodule, but then also does another `git submodule foreach`
     * @param string $repo
     * @param string $name
     * @return null
     */
    public function checkSubSubmodules($repo, $name) {
        $output = $this->gitCommand('submodule foreach git submodule status', $repo);

        if (count($output) > 0) {
            foreach ($output as $line) {
                $line = explode(' ', trim($line));

                // Skip if string start with 'Entering'
                if (trim($line[0]) == 'Entering') continue;

                // If sub-submodules are turned off, don't add them to queue
                if ($this->scanSubmodules && $this->scanSubSubmodules) {
                    $this->submodules[] = array(
                        'revision' => $line[0],
                        'name'     => $name . '/' . $line[1],
                        'path'     => $repo . '/' . $name . '/' . $line[1]
                    );
                    $this->output(sprintf('      Found sub-submodule %s.', "$name/$line[1]"));
                }

                // But ignore them nonetheless
                $this->globalFilesToIgnore[] = $line[1];
            }
        }
    }

    /**
     * Reads the deploy.ini file and populates the $this->servers array
     *
     * @return null
     */
    public function prepareServers() {
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
            'revdir'  => '' //where to store the .revision file
        );

        $servers = $this->options['ftp'];
        $this->output($servers);

        foreach ($servers as $name => $options) {

            $options = array_merge($defaults, $options);

            // Determine if a default server is configured : gitftp only uses default.
            if ($name == 'default') {
                $this->defaultServer = TRUE;
            }

            // Re-merge parsed url in quickmode
            if (isset($options['quickmode'])) {
                $options = array_merge($options, parse_url($options['quickmode']));
            }

            // Ignoring for the win
            $this->filesToIgnore[$name] = $this->globalFilesToIgnore;

            if (!empty($servers[$name]['skip'])) {
                $this->filesToIgnore[$name] = array_merge($this->filesToIgnore[$name], $servers[$name]['skip']);
            }

            if (!empty($servers[$name]['purge'])) {
                $this->purgeDirs[$name] = $servers[$name]['purge'];
            }

            $bridgeOptions = array();

            if ($options['pubkey'] !== '' || $options['privkey'] !== '') {
                $key = array(
                    'pubkeyfile'  => FALSE,
                    'privkeyfile' => FALSE,
                    'user'        => $options['user'], //username
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

            $this->servers[$name] = array(
                'url'     => http_build_url('', $options), // Turn options into an URL so that Bridge can work with it.
                'options' => $bridgeOptions, // Options for Bridge
                'revdir'  => $options['revdir']
            );
        }
    }

    /**
     * Executes a console command and returns the output (as an array)
     *
     * @return array of all lines that were output to the console during the command (STDOUT)
     */
    public function runCommand($command) {
        // Escape special chars in string with a backslash
        $command = escapeshellcmd($command);
        $this->output("CONSOLE: $command");
        exec($command, $output);
        $this->output($output);

        return $output;
    }

    /**
     * Runs a git command and returns the output (as an array)
     *
     * @param string $command "git [your-command-here]"
     * @param string $repoPath Defaults to $this->repo
     * @return array Lines of the output
     */
    public function gitCommand($command, $repoPath = NULL) {
        if (!$repoPath) {
            $repoPath = $this->repo;
        }

        $command = 'git --git-dir="' . $repoPath . '/.git" --work-tree="' . $repoPath . '" ' . $command;

        return $this->runCommand($command);
    }

    /**
     * Compare revisions and returns array of files to upload:
     *
     *      array(
     *          'upload' => $filesToUpload,
     *          'delete' => $filesToDelete
     *      );
     *
     * @param string $localRevision
     * @return array
     * @throws Exception if unknown git diff status
     */
    public function compare($localRevision) {
        $remoteRevision = NULL;
        $tmpFile = tmpfile();
        $filesToUpload = array();
        $filesToDelete = array();
        $filesToSkip = array();
        $output = array();

        if ($this->currentSubmoduleName) {
            $this->dotRevision = $this->currentSubmoduleName . '/' . $this->dotRevisionFilename;
        } else {
            $this->dotRevision = join('/', array(trim($this->dotRevisionDir, '/'), trim($this->dotRevisionFilename, '/')));
        }

        // Fetch the .revision file from the server and write it to $tmpFile
        $this->output("Getting revision");

        if (!empty($this->options['remoteRevision'])) {
            $remoteRevision = $this->options['remoteRevision'];
            $this->output('Revision on server: ' . $remoteRevision);
            $this->log('remoteRevision_before', $remoteRevision);
        } else {
            $this->log('remoteRevision_before', '');
            $this->output('No revision found. Fresh deployment - sit back and relax.');
        }

        // Use git to list the changed files between $remoteRevision and $localRevision
        // "-c core.quotepath=false" in command fixes special chars issue like Ã«, Ã¤ or Ã¼ in file names
        if ($this->others) {
            $command = '-c core.quotepath=false ls-files -o';
        } elseif (empty($remoteRevision)) {
            $command = '-c core.quotepath=false ls-files';
        } else if ($localRevision === 'HEAD') {
//            $command = '-c core.quotepath=false diff --name-status ' . $remoteRevision . '...' . $localRevision;
            $command = '-c core.quotepath=false diff --name-status ' . $remoteRevision . ' ' . $localRevision;
        } else {
            $command = '-c core.quotepath=false diff --name-status ' . $remoteRevision . '... ' . $localRevision;
        }

        $output = $this->gitCommand($command);
        $this->output($command);
        print_r($output);
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

        $filesToUpload = $filteredFilesToUpload['files'];
        $filesToDelete = $filteredFilesToDelete['files'];

        $filesToSkip = array_merge($filteredFilesToUpload['filesToSkip'], $filteredFilesToDelete['filesToSkip']);

        // CP: log
        $this->log('files', array(
            'upload' => count($filesToUpload),
            'delete' => count($filesToDelete),
            'skip'   => count($filesToSkip),
        ));

        return array(
            $this->currentlyDeploying => array(
                'delete' => $filesToDelete,
                'upload' => $filesToUpload,
                'skip'   => $filesToSkip,
            )
        );
    }

    /**
     * Filter ignore files
     *
     * @param array $files Array of files which needed to be filtered
     * @return Array with `files` (filtered) and `filesToSkip`
     */
    private function filterIgnoredFiles($files) {
        $filesToSkip = array();

        foreach ($files as $i => $file) {
            foreach ($this->filesToIgnore[$this->currentlyDeploying] as $pattern) {
                if ($this->patternMatch($pattern, $file)) {
                    unset($files[$i]);
                    $filesToSkip[] = $file;
                    break;
                }
            }
        }

        $files = array_values($files);

        return array(
            'files'       => $files,
            'filesToSkip' => $filesToSkip
        );
    }

    /**
     * Deploy (or list) changed files
     * @param string $revision
     */
    public function deploy($revision = 'HEAD') {
        $this->output('deploying to ' . $revision);

        $this->prepareServers();

        // Loop through all the servers in deploy.ini
        foreach ($this->servers as $name => $server) {

            $this->currentlyDeploying = $name;

            // CP: log
            $this->output('Currently deploying: ' . $this->currentlyDeploying);

            // Deploys to ALL servers by default
            // If a server is specified, we skip all servers that don't match the one specified
            if ($this->server != '' && $this->server != $name) continue;

            // If no server was specified in the command line but a default server
            // configuration exists, we'll use that (as long as --all was not specified)
            elseif ($this->server == '' && $this->defaultServer == TRUE && $name != 'default' && $this->deployAll == FALSE) continue;

            try {
                $this->connect($server);
            } catch (Exception $e) {
                $this->log('error', $e->getMessage());
                throw new \Exception($e->getMessage());
            }

            if ($this->sync) {
                $this->dotRevision = $this->dotRevisionFilename;
                $this->setRevision();
                continue;
            }

            $this->dotRevisionDir = $server['revdir'];
            $files = $this->compare($revision);

            if ($this->debug)
                $this->output($files);

            $this->output("SERVER: " . $name);

            if ($this->listFiles === TRUE) {
                // CP: NOT USED.
                $this->listFiles($files[$this->currentlyDeploying]);
            } else {
                $this->push($files[$this->currentlyDeploying]);
                // Purge
                if (isset($this->purgeDirs[$name]) && count($this->purgeDirs[$name]) > 0) {
                    $this->output("Purging ...");
                    $this->log("Purging ...");
                    $this->purge($this->purgeDirs[$name]);
                }
            }

            if ($this->scanSubmodules && count($this->submodules) > 0) {
                foreach ($this->submodules as $submodule) {
                    $this->repo = $submodule['path'];
                    $this->currentSubmoduleName = $submodule['name'];

                    $this->output("\r\n<gray>SUBMODULE: " . $this->currentSubmoduleName);

                    $files = $this->compare($revision);

                    if ($this->listFiles === TRUE) {
                        $this->listFiles($files[$this->currentlyDeploying]);
                    } else {
                        $this->push($files[$this->currentlyDeploying]);
                    }
                }
                // We've finished deploying submodules, reset settings for the next server
                $this->repo = $this->mainRepo;
                $this->currentSubmoduleName = FALSE;
            }

            // Done
            if (!$this->listFiles) {
                $this->output($this->humanFilesize($this->deploymentSize) . " Deployed");

                $this->log('deployed', array(
                    'data'  => $this->deploymentSize,
                    'human' => $this->humanFilesize($this->deploymentSize)
                ));

                $this->deploymentSize = 0;
            }
        }
    }

    /**
     * Return a human readable filesize
     *
     * @param int $bytes
     * @param int $decimals
     */
    public function humanFilesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    /**
     * Glob the file path
     *
     * @param string $pattern
     * @param string $string
     */
    function patternMatch($pattern, $string) {
        return preg_match("#^" . strtr(preg_quote($pattern, '#'), array('\*' => '.*', '\?' => '.')) . "$#i", $string);
    }

    /**
     * TODO: will be used.
     * Check what files will be uploaded/deleted
     *
     * @param array $files
     */
    public function listFiles($files) {
        if (count($files['upload']) == 0 && count($files['delete']) == 0) {
            $this->output("No files to upload.");
        }

        if (count($files['delete']) > 0) {
            $this->output("Files that will be deleted in next deployment:");

            foreach ($files['delete'] as $file_to_delete) {
                $this->output($file_to_delete);
            }
        }

        if (count($files['upload']) > 0) {
            $this->output("Files that will be uploaded in next deployment:");

            foreach ($files['upload'] as $file_to_upload) {
                $this->output($file_to_upload);
            }
        }
    }

    /**
     * Connect to the Server
     *
     * @param string $server
     * @throws Exception if it can't connect to FTP server
     */
    public function connect($server) {
        $connection = new bridge($server['url'], $server['options']);
        $this->connection = $connection;
    }

    /**
     * Update the current remote server with the array of files provided
     *
     * @param array $files 2-dimensional array with 2 indices: 'upload' and 'delete'
     *                     Each of these contains an array of filenames and paths (relative to repository root)
     */
    public function push($files) {
        // We will write this in the server
        $this->localRevision = $this->currentRevision();

        $initialBranch = $this->currentBranch();

        // If revision is not HEAD, the current one, it means this is a rollback.
        // So, we have to revert the files the the state they were in that revision.
        if ($this->revision != 'HEAD') {
            $this->output("   Rolling back working copy");

            // BUG: This does NOT work correctly for submodules & subsubmodules (and leaves them in an incorrect state)
            //      It technically should do a submodule update in the parent, not a checkout inside the submodule
            $this->gitCommand('checkout ' . $this->revision);
        }

        $filesToDelete = $files['delete'];
        $filesToUpload = $files['upload'];

        unset($files);
        $this->output("Starting processing files.");

        // CP:
        // ----------------------------------

        $totalcount = count($filesToDelete) + count($filesToUpload);
        $curr = 0;
        $record = new Model_Record();
        $record_id = $this->options['record_id'];

        /**
         * set total count.
         */
        $record->set($record_id, array(
            'total_files' => $totalcount
        ), TRUE);

        $this->output("files to process $totalcount");
        $this->log($totalcount . ' file(s) to process');
        // ----------------------------------

        // TODO: perhaps detect whether file is actually present, and whether delete is successful/skipped/failed
        foreach ($filesToDelete as $fileNo => $file) {

            $numberOfFilesToDelete = count($filesToDelete);
//            if ($this->connection->exists($file)) {
//                $this->connection->rm($file);
//                $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToDelete), ' ', STR_PAD_LEFT);
//                $this->log("x removed $fileNo of $numberOfFilesToDelete {$file}");
//                $this->output("x removed $fileNo of $numberOfFilesToDelete {$file}");
//            } else {
//                $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToDelete), ' ', STR_PAD_LEFT);
//                $this->log("not found $fileNo of $numberOfFilesToDelete {$file}");
//                $this->output("not found $fileNo of $numberOfFilesToDelete {$file}");
//            }
//            if ($this->connection->exists($file)) {
            try {
                $this->connection->rm($file);
                $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToDelete), ' ', STR_PAD_LEFT);
                $this->log("x removed $fileNo of $numberOfFilesToDelete {$file}");
                $this->output("x removed $fileNo of $numberOfFilesToDelete {$file}");
            } catch (Exception $e) {
                $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToDelete), ' ', STR_PAD_LEFT);
                $this->log("not found $fileNo of $numberOfFilesToDelete {$file}");
                $this->output("not found $fileNo of $numberOfFilesToDelete {$file}");
            }

            $curr += 1;
            $record->set($record_id, array(
                'processed_files' => $curr
            ), TRUE);

        }

        // Upload Files
        foreach ($filesToUpload as $fileNo => $file) {
            if ($this->currentSubmoduleName) $file = $this->currentSubmoduleName . '/' . $file;

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

                        try {
                            $origin = $this->connection->pwd();
                        } catch (Exception $e) {
                            $this->output('Failed to read root path from server.');
                            $this->log('Failed to read root path from server.');
                            throw new \Exception($e->getMessage());
                        }

                        if (!$this->connection->exists($path)) {
                            try {
                                $this->connection->mkdir($path);
                            } catch (Exception $e) {
                                $this->output('Failed to create directory: ' . $path);
                                $this->log('Failed to create directory: ' . $path);
                                throw new \Exception($e->getMessage());
                            }

                            $this->output("Created directory '$path'.");
                            $this->log("Created directory '$path'.");

                            $pathsThatExist[$path] = TRUE;
                        } else {
                            try {
                                $this->connection->cd($path);
                            } catch (Exception $e) {
                                $this->output('Failed to change directory to: ' . $path);
                                $this->log('Failed to change directory to: ' . $path);
                                throw new \Exception($e->getMessage());
                            }
                            $pathsThatExist[$path] = TRUE;
                        }

                        // Go home
                        try {
                            $this->connection->cd($origin);
                        } catch (Exception $e) {
                            $this->output('Failed to change directory to: ' . $origin);
                            $this->log('Failed to change directory to: ' . $origin);
                            throw new \Exception($e->getMessage());
                        }
                    }
                }
            }

            // Now upload the file, attempting 10 times
            // before exiting with a failure message
            $uploaded = FALSE;
            $attempts = 1;
            while (!$uploaded) {
                if ($attempts == 10) {
                    $this->output("Tried to upload $file 10 times and failed, Please check file permissions on your server.");
                    $this->log("Tried to upload $file 10 times and failed, Please check file permissions on your server.");
                    throw new \Exception("Tried to upload $file 10 times and failed. Please check permissions.");
                }
                $data = file_get_contents($file);
                $remoteFile = $file;
                $uploaded = $this->connection->put($data, $remoteFile);

                if (!$uploaded) {
                    $attempts = $attempts + 1;
                    $this->output("Failed to upload {$file}. Retrying (attempt $attempts/10)... ");
                } else {
                    $this->deploymentSize += filesize(getcwd() . '/' . $file);
                }
            }

            $numberOfFilesToUpdate = count($filesToUpload);

            $fileNo = str_pad(++$fileNo, strlen($numberOfFilesToUpdate), ' ', STR_PAD_LEFT);
            $this->output("^ uploaded $fileNo of $numberOfFilesToUpdate {$file}");

            $curr += 1;
            $record->set($record_id, array(
                'processed_files' => $curr
            ), TRUE);
        }

        if (count($filesToUpload) > 0 or count($filesToDelete) > 0) {
            // Set revision on server
            $this->setRevision();
        } else {
            $this->setRevision();

            $this->output("No files to upload.");
            $record->set($record_id, array(
                'processed_files' => 0
            ), TRUE);
        }

        // If $this->revision is not HEAD, it means the rollback command was provided
        // The working copy was rolled back earlier to run the deployment, and we now want to return the working copy
        // back to its original state
        if ($this->revision != 'HEAD') {
            $this->gitCommand('checkout ' . ($initialBranch ?: 'master'));
        }
    }

    /**
     * Gets the current branch name.
     *
     * @return string - current branch name or false if not in branch
     */
    private function currentBranch() {
        $currentBranch = $this->gitCommand('rev-parse --abbrev-ref HEAD')[0];
        if ($currentBranch != 'HEAD') {
            return $currentBranch;
        }

        return FALSE;
    }

    /**
     * Sets version hash on the server.
     */
    public function setRevision() {
        $this->log('remoteRevision_after', $this->localRevision);
    }

    /**
     * Purge given directory's contents
     *
     * @var string $purgeDirs
     */
    public function purge($purgeDirs) {
        foreach ($purgeDirs as $dir) {
            $this->output('------ ' . $dir);
            $origin = $this->connection->pwd();
            if(substr($dir, 0, 1) == '/'){
                $this->log("Warning: Leading slash may delete all files in root directory: $dir.");
                $dir = substr($dir, 1, strlen($dir));
                $this->log("Using $dir instead");
            }

            try {
                $this->connection->cd($dir);
            } catch (Exception $e) {
                $this->log('Ignoring directory "' . $dir . '", reason: doesn\'t exist.');
                continue;
            }

            if (!$tmpFiles = $this->connection->ls()) {
                $this->output("Nothing to purge in {$dir}");
                $this->log("Nothing to purge in {$dir}");
                continue;
            }

            foreach ($tmpFiles as $file) {
                try {
                    // Okay folder found.
                    $this->connection->cd($file);
                    $this->connection->cd('../');
                    $this->output($file . ' is a folder.');
                    $this->purge(array($file));
                    $this->connection->rmdir($file);
                } catch (Exception $e) {
                    // Its a file. remove it !
                    try {
                        $this->connection->rm($file);
                        $this->output("Purged file $file");
                    } catch (Exception $e) {
                        $this->log('could not purge file: ' . $file);
                    }
                }
            }

            $this->output("Purged {$dir}");
            $this->connection->cd($origin);
        }
    }

    /**
     * Helper method to display messages on the screen.
     *
     * @param string $message
     */
    public function output($message) {
        if ($this->debug) {
            if (is_array($message)) {
                $message = print_r($message, TRUE);
            }
            fwrite(STDOUT, "~ $message\n");
        }
    }

    /**
     * Log progress and errors for the user to view.
     *
     * @param $message
     */
    public function log($a, $b = NULL) {
        if (is_null($b)) {
            array_push($this->log, $a);
        } else {
            $this->log[$a] = $b;
        }
    }
}
