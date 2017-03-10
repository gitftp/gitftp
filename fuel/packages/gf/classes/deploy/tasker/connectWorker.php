<?php

class ConnectWorker extends Worker {

    public $connection;

    /**
     * ConnectWorker constructor.
     *
     * @param $connection
     */
    public function __construct ($connection) {
        $this->connection = $connection;
    }

    public function run () {
        echo "This is run just once for each worker. " . $this->getSomething() . " \n ";
    }

    public function getSomething () {
        return $this->say;
    }
}