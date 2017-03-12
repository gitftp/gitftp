<?php

namespace Gf\Deploy;

use Gf\Exception\AppException;
use Gf\Server;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class Connection {


    /**
     * Instance for the connection class
     *
     * @var Connection
     */
    private static $instance;

    /**
     * Server configuration details.
     *
     * @var array
     */
    private $server_data;

    /**
     * @var Filesystem
     */
    private $connection;

    /**
     * Connection constructor.
     *
     * @param $server_data
     *
     * @internal param $project_id
     */
    protected function __construct ($server_data) {
        $this->server_data = $server_data;

        if ($this->server_data['type'] == Server::type_ftp) {
            $this->connectFtp();
        } elseif ($this->server_data['type'] == Server::type_sftp) {
            $this->connectSftp();
        } elseif ($this->server_data['type'] == Server::type_local) {
            $this->connectLocal();
        }
    }

    /**
     * @param array|int $server_data -> server data or server id.
     *
     * @return \Gf\Deploy\Connection
     * @throws \Gf\Exception\AppException
     */
    public static function instance ($server_data) {
        if (gettype($server_data) == 'integer') {
            $server_data = Server::get_one([
                'id' => $server_data,
            ]);
            if (!$server_data)
                throw new AppException('The server does not exists');
        }


        if (!isset(static::$instance) or null == static::$instance) {
            static::$instance = new static($server_data);
        }

        return self::$instance;
    }

    private function connectFtp () {
        $filesystem = new Filesystem(new Ftp([
            'host'     => $this->server_data['host'],
            'username' => $this->server_data['username'],
            'password' => $this->server_data['password'],

            /** optional config settings */
            'port'     => $this->server_data['port'],
            'root'     => $this->server_data['path'],
            'passive'  => true,
            'ssl'      => (Bool)$this->server_data['secure'],
            'timeout'  => 30,
        ]));

        $this->connection = $filesystem;
    }


    private function connectSftp () {
        $filesystem = new Filesystem(new SftpAdapter([
            'host'     => $this->server_data['host'],
            'username' => $this->server_data['username'],
            'password' => $this->server_data['password'],
            'port'     => $this->server_data['port'],
//            'privateKey' => $this->server_data['path'],
            'root'     => $this->server_data['path'],
            'timeout'  => 10,
        ]));

        $this->connection = $filesystem;
    }

    private function connectLocal () {
        $filesystem = new Filesystem(new Local($this->server_data['path']));
        $this->connection = $filesystem;
    }

    /**
     * @return \League\Flysystem\Filesystem
     */
    public function connection () {
        return $this->connection;
    }


}