<?php

namespace Gf\Deploy\Tasker;

class ConnectionWorker extends \Worker {

    /**
     * The current server details
     *
     * @var
     */
    public $server;

    /**
     * The on going record details.
     *
     * @var
     */
    public $record;

    /**
     * @var
     */
    private $git;

    /**
     * Number of files that his worker has processed
     * this is incremented by @see FileTask class
     *
     * @var int
     */
    public $fileProgress = 0;


    /**
     * ConnectWorker constructor.
     *
     * @param $server
     * @param $record
     * @param $gitWrapper
     * @param $connection
     *
     * @internal param $connection
     */
    public function __construct ($server, $record, $gitWrapper, $connection) {
        $this->server = $server;
        $this->record = $record;
        $this->git = $gitWrapper;
    }

    public function run () {

    }
}