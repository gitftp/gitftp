<?php

namespace Gf\Deploy\Tasker;

use Fuel\Core\File;
use Gf\Deploy\Deploy;
use Gf\Exception\AppException;
use Gf\Record;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;
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
     * Messages that come up during the uploading
     *
     * @var string
     */
    public $messages = '';

    /**
     * @var Filesystem
     */
    private $connection;
    private $server;
    private $record;

    /**
     * @var GitWorkingCopy
     */
    private $git;

    /**
     * @param null $method
     *
     * @return Deployer
     */
    public static function instance ($method = null, $gitWrapper) {
        if (!isset(static::$instance) or null == static::$instance) {
            static::$instance = new static($method, $gitWrapper);
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
     * @param null $method
     */
    public function __construct ($method = null, $gitWrapper) {
        $this->git = $gitWrapper;
        $this->method = $method;

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
     * @return string
     */
    public function getMessages () {
        return $this->messages;
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
    public function setConnection ($connection) {
        $this->connection = $connection;

        return $this;
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
        // hey boo
        if ($this->method == self::method_pthreads)
            return $this->pThreads();
        elseif ($this->method == self::method_regular)
            return $this->regular();
    }

    private function regular () {
        $r = $this->record['target_revision'];
        $dir = $this->git->getDirectory();

        foreach ($this->files as $file) {
            if ($file['action'] == Deploy::file_action_upload) {

                /* $s = "$r:{$file['file']}";
                $this->git->clearOutput();
                $this->git->run([
                    'show',
                    $s,
                ]);
                $contents = $this->git->getOutput();*/

                $s = $dir . $file['file'];
                $contents = File::read($s, true);

                $this->connection->put($file['file'], $contents);
                $this->incrementProgress(1);
            } elseif ($file['action'] == Deploy::file_action_delete) {
                $this->connection->delete($file['file']);
                $this->incrementProgress(1);
            } else {
                throw new AppException('Invalid file action type');
            }
        }

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
