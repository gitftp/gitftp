<?php

namespace Gf\Deploy\Tasker;

use Fuel\Core\Cli;
use Fuel\Core\File;
use Gf\Deploy\Connection;
use Gf\Deploy\Deploy;
use Gf\Deploy\DeployLog;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\GitLocal;
use Gf\Record;
use League\Flysystem\Filesystem;

class Deployer {
    const method_pthreads = 'pt';
    const method_regular = 'r';
    private static $instance;

    /**
     * The method that will be used for uploading files.
     *
     * @var
     */
    public $method;

    /**
     * Holds the server data
     *
     * @var array
     */
    public $connectionParams;

    /**
     * @var
     */
    private $files;

    /**
     * The number of processed files.
     *
     * @var int
     */
    public $progress = 0;

    /**
     * number of files, which is the total progress.
     *
     * @var int
     */
    public $total_progress = 0;

    /**
     * @var Connection
     */
    private $connection;
    private $server;
    private $record;

    /**
     * @var GitLocal
     */
    private $gitLocal;

    /**
     * @param null             $method
     * @param \Gf\Git\GitLocal $gitLocal
     * @param array            $connectionParams
     *
     * @return \Gf\Deploy\Tasker\Deployer
     */
    public static function instance ($method = null, GitLocal $gitLocal, Array $connectionParams) {
        if (!isset(static::$instance) or null == static::$instance) {
            static::$instance = new static($method, $gitLocal, $connectionParams);
        }

        return self::$instance;
    }

    /**
     * @param mixed $record
     *
     * @return $this
     */
    public function setRecord ($record) {
        $this->record = $record;

        return $this;
    }

    /**
     * @param mixed $server
     *
     * @return $this
     */
    public function setServer ($server) {
        $this->server = $server;

        return $this;
    }


    /**
     * Deployer constructor.
     *
     * @param null             $method
     * @param \Gf\Git\GitLocal $gitLocal
     * @param array            $connectionParams
     */
    public function __construct ($method = null, GitLocal $gitLocal, Array $connectionParams) {
        $this->gitLocal = $gitLocal;
        $this->method = $method;
        $this->connectionParams = $connectionParams;
        $this->connect();

        if (is_null($this->method))
            $this->method = self::method_pthreads;

        if ($this->method == self::method_pthreads) {
            $extensions = get_loaded_extensions();
            $extensions = array_flip($extensions);
            if (!isset($extensions['pthreads'])) {
                // sad, retreat to regular
                $this->method = self::method_regular;
            }
        }
    }

    public function getMethod () {
        return $this->method;
    }

    /**
     * Clear the current queue of files.
     *
     * @return $this
     */
    public function clearFiles () {
        $this->files = [];
        $this->total_progress = 0;
        $this->progress = 0;

        return $this;
    }


    /**
     * The files should be in format
     * ['path' => 'full/path/to/file', 'action' => upload|delete]
     *
     * @param $files
     *
     * @return $this
     */
    public function addFiles (Array $files) {
        $this->files = $files;
        $this->total_progress = count($this->files);

        return $this;
    }

    /**
     * @return int
     */
    public function getProgress () {
        return $this->progress;
    }


    /**
     * Give in the database connection.
     *
     * @param $connection
     *
     * @return $this
     */
    public function setConnection (Connection $connection) {
        $this->connection = $connection;

        return $this;
    }

    public function connect () {
        if (!$this->connectionParams or !count($this->connectionParams))
            throw new AppException('Connection params not found');

        $connection = Connection::instance($this->connectionParams);
        $this->setConnection($connection);
    }

    /**
     * inserts the progress in the database
     *
     * @param int $number
     */
    private function incrementProgress ($number = 1) {
        $this->progress += $number;

        if ($this->progress % 2 == 0 || $this->progress == $this->total_progress)
            Record::update([
                'id' => $this->record['id'],
            ], [
                'processed_files' => $this->progress,
            ]);
    }

    /**
     * Start the deployment process
     */
    public function start () {
        DeployLog::log('Starting deployer');

        if ($this->method == self::method_pthreads)
            return $this->pThreads();
        elseif ($this->method == self::method_regular)
            return $this->regular();
        else
            throw new AppException("Invalid method {$this->method}");
    }

    private function regular () {
        $r = $this->record['target_revision'];
        $dir = $this->gitLocal->git->getDirectory();

        DeployLog::log('Upload method: regular');

        $totalFiles = count($this->files);

        /*
         * Goes on until all the files are done
         * If errors come up on delete, ignore them, they were to be deleted anyway.
         * If errors come up on update, retry 3 times, then abort
         * */
        while (($this->progress) != $totalFiles) {
            $file = $this->files[$this->progress];

            if ($file['a'] == Deploy::file_added or $file['a'] == Deploy::file_modified) {
                $s = $dir . $file['f'];
                $contents = File::read($s, true);
                try {
                    DeployLog::log('Uploading.. ' . $file['f']);
                    $this->connection->put($file['f'], $contents);
                    $this->incrementProgress(1);
                } catch (\Exception $e) {
                    if (!isset($this->files[$this->progress]['retry']))
                        $this->files[$this->progress]['retry'] = 0;

                    $this->files[$this->progress]['retry'] += 1;
                    if ($this->files[$this->progress]['retry'] >= 4) {
                        DeployLog::log("UPLOAD ERR: {$e->getMessage()} {$file['f']}");
                        throw new AppException("Upload failed {$this->files[$this->progress]['retry']} times: {$e->getMessage()}, file: {$file['f']}");
                    } else {
                        DeployLog::log("UPLOAD RETRY: {$e->getMessage()} {$file['f']}");
                    }
                }
            } elseif ($file['a'] == Deploy::file_deleted) {
                try {
                    DeployLog::log('Deleting ' . $file['f']);
                    $this->connection->delete($file['f']);
                } catch (\Exception $e) {
                    DeployLog::log("DELETE ERR: Ignored {$e->getMessage()} {$file['f']}");
                    // error on delete. ignored.
                }
                $this->incrementProgress(1);
            } else {
                throw new AppException("Invalid file action: {$file['a']} {$file['f']}");
            }
            DeployLog::log("Progress {$this->progress} - {$this->total_progress}");
        }

//
//        foreach ($this->files as $file) {
//            if ($file['a'] == Deploy::file_added or $file['a'] == Deploy::file_modified) {
//                $s = $dir . $file['f'];
//                $contents = File::read($s, true);
//                try {
//                    DeployLog::log('Uploading.. ' . $file['f']);
//                    $this->connection->put($file['f'], $contents);
//                } catch (\Exception $e) {
//                    DeployLog::log("WARN: {$e->getMessage()} {$file['f']}");
//                }
//                $this->incrementProgress(1);
//            } elseif ($file['a'] == Deploy::file_deleted) {
//                try {
//                    DeployLog::log('Deleting ' . $file['f']);
//                    $this->connection->delete($file['f']);
//                } catch (\Exception $e) {
//                    DeployLog::log("WARN: Ignored {$e->getMessage()} {$file['f']}");
//                }
//                $this->incrementProgress(1);
//            } else {
//                throw new AppException('Invalid file action type');
//            }
//            DeployLog::log("Progress {$this->progress} - {$this->total_progress}");
//        }

        return true;
    }

    private function pThreads () {
//        $workPool = new \Pool(2, ConnectionWorker::class, [
//            $this->currentServer,
//            $this->currentRecord,
//            $this->git,
//            $connection->connection(),
//        ]);
//
//        foreach ($allFiles as $fileAction) {
//            $workPool->submit(new FileTask($fileAction));
//        }
//
//        $workPool->shutdown();
//
//        $workPool->collect(function ($checkingTask) {
//            var_dump($checkingTask);
//        });

        return true;
    }

}
