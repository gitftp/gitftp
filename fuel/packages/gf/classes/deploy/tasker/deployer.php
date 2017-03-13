<?php

namespace Gf\Deploy\Tasker;

class Deployer {
    const method_pthreads = 'pt';
    const method_regular = 'r';

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


    private $connection;
    private $server;
    private $record;

    /**
     * Deployer constructor.
     *
     * @param      $server
     * @param      $record
     * @param null $method
     */
    public function __construct ($server, $record, $method = null) {
        $this->method = $method;
        $this->server = $server;
        $this->record = $record;

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
     * The files should be in format
     * ['path' => 'full/path/to/file', 'action' => upload|delete]
     *
     * @param $files
     */
    public function addFiles (Array $files) {
        $this->files = $files;
    }

    /**
     * Give in the database connection.
     *
     * @param $connection
     */
    public function setConnection ($connection) {
        $this->connection = $connection;
    }


}
