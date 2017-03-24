<?php

namespace Gf\Deploy;

use Fuel\Core\File;
use Gf\Exception\AppException;
use Gf\Keys;
use Gf\Server;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Adapter\Ftpd;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

/**
 * Wrapper class for flysystem filesystem
 * Class Connection
 *
 * @package Gf\Deploy
 */
class Connection {
    /**
     * Instance for the connection class
     *
     * @var Connection[]
     */
    private static $instances;

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
     * Server type
     *
     * @var
     */
    private $type;

    /**
     * Connection constructor.
     *
     * @param $server_data
     *
     * @internal param $project_id
     */
    protected function __construct ($server_data) {
        $this->server_data = $server_data;
        $this->type = $this->server_data['type'];

        $this->connect();
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

        if (!isset($server_data['id']))
            $server_data['id'] = '0';

        if (!isset(static::$instances[$server_data['id']]) or null == static::$instances[$server_data['id']]) {
            static::$instances[$server_data['id']] = new static($server_data);
        }

        return self::$instances[$server_data['id']];
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
        $options = [
            'host'     => $this->server_data['host'],
            'username' => $this->server_data['username'],
            'port'     => $this->server_data['port'],
            'root'     => $this->server_data['path'],
            'timeout'  => 30,
        ];

        if (isset($this->server_data['key_id'])) {
            $options['privateKey'] = Keys::getById($this->server_data['key_id'], Keys::privateKey);
        } else {
            $options['password'] = $this->server_data['password'];
        }

        $filesystem = new Filesystem(new SftpAdapter($options));

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

    public function connect () {
        if ($this->type == Server::type_ftp) {
            $this->connectFtp();
            $this->connection->getAdapter()->connect();
        } elseif ($this->type == Server::type_sftp) {
            $this->connectSftp();
            $this->connection->getAdapter()->connect();
        } elseif ($this->type == Server::type_local) {
            $this->connectLocal();
        }
    }

    public function isConnected () {
        if ($this->type == Server::type_ftp) {
            return $this->connection->getAdapter()->isConnected();
        } elseif ($this->type == Server::type_sftp) {
            return $this->connection->getAdapter()->isConnected();
        } elseif ($this->type == Server::type_local) {
            return true;
        }
    }

    public function reconnectIfNotConnected () {
        if (!$this->isConnected()) {
            $this->connect();
        }
    }

    /**
     * @param       $path
     * @param       $contents
     * @param array $config
     *
     * @return bool
     */
    public function write ($path, $contents, $config = []) {
        $this->reconnectIfNotConnected();

        return $this->connection->write($path, $contents, $config);
    }

    /**
     * @param       $path
     * @param       $contents
     * @param array $config
     *
     * @return bool
     */
    public function put ($path, $contents, $config = []) {
        $this->reconnectIfNotConnected();

        return $this->connection->put($path, $contents, $config);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function delete ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->delete($path);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function deleteDir ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->deleteDir($path);
    }

    /**
     * @param $path
     * @param $newPath
     *
     * @return bool
     */
    public function rename ($path, $newPath) {
        $this->reconnectIfNotConnected();

        return $this->connection->rename($path, $newPath);
    }

    /**
     * @param $path
     * @param $newPath
     *
     * @return bool
     */
    public function copy ($path, $newPath) {
        $this->reconnectIfNotConnected();

        return $this->connection->copy($path, $newPath);
    }

    /**
     * @param       $path
     * @param array $config
     *
     * @return bool
     */
    public function createDir ($path, $config = []) {
        $this->reconnectIfNotConnected();

        return $this->connection->createDir($path, $config);
    }

    /**
     * @return \League\Flysystem\AdapterInterface
     */
    public function getAdapter () {
        $this->reconnectIfNotConnected();

        return $this->connection->getAdapter();
    }

    /**
     * @param $path
     *
     * @return array|false
     */
    public function getMetadata ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->getMetadata($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     */
    public function getMimetype ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->getMimetype($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|int
     */
    public function getSize ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->getSize($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     */
    public function getTimestamp ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->getTimestamp($path);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function has ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->has($path);
    }

    /**
     * @param $path
     *
     * @return array
     */
    public function listContents ($path = '') {
        $this->reconnectIfNotConnected();

        return $this->connection->listContents($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     */
    public function read ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->read($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     */
    public function readAndDelete ($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->readAndDelete($path);
    }

    /**
     * @param       $path
     * @param       $content
     * @param array $config
     *
     * @return bool
     */
    public function update ($path, $content, $config = []) {
        $this->reconnectIfNotConnected();

        return $this->connection->update($path, $content, $config);
    }
}