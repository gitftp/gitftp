<?php

namespace App\Models\Deploy;

class Connection {

    public function __construct() {

    }

    private $server;
    private $type;

    const LOCAL = 'local';
    const FTP = 'ftp';
    const SFTP = 'sftp';

    /**
     * @param mixed $server
     */
    public function setServer($server) {
        $this->server = $server;
        $this->type = $server->type;

        return $this;
    }

    public function setServerId($serverId) {

    }

    /**
     * @var \League\Flysystem\FilesystemAdapter
     */
    private $connection;

    /**
     * @return $this
     */
    public function connect() {
        switch ($this->type) {
            case self::LOCAL:
                //                $filesystem = new \League\Flysystem\Filesystem(new \League\Flysystem\Local\LocalFilesystemAdapter($this->server->path));
                $ad = new \League\Flysystem\Local\LocalFilesystemAdapter('./../');
                $filesystem = new \League\Flysystem\Filesystem($ad);
                $this->connection = $filesystem;
                //                $ad->listContents('/')
                break;
            case self::FTP:
            case self::SFTP:
                //                $this->connection->getAdapter()
                //                                 ->connect();
                break;
        }


        return $this;
    }

    /**
     * @return \League\Flysystem\FilesystemAdapter
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * @return void
     */
    public function reconnectIfNotConnected() {
        if (!$this->isConnected()) {
            $this->connect();
        }
    }

    /**
     * @return true|void
     */
    public function isConnected() {
        switch ($this->type) {
            case self::LOCAL:
                return true;
                break;
            case self::SFTP:
            case self::FTP:
                //            return $this->connection->getAdapter()->isConnected();
                break;
        }
    }


    /**
     * @param       $path
     * @param       $contents
     * @param array $config
     *
     * @return void
     */
    public function write($path, $contents, $config = []) {
        $this->reconnectIfNotConnected();

        $this->connection->write($path, $contents, $config);
    }

    /**
     * @param       $path
     * @param       $contents
     * @param array $config
     *
     * @return bool
     */
    public function put($path, $contents, $config = []) {
        $this->reconnectIfNotConnected();

        return $this->connection->put($path, $contents, $config);
    }

    /**
     * @param $path
     *
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FilesystemException
     */
    public function delete($path) {
        $this->reconnectIfNotConnected();

        $this->connection->delete($path);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function deleteDir($path): bool {
        $this->reconnectIfNotConnected();

        return $this->connection->deleteDir($path);
    }

    /**
     * @param $path
     * @param $newPath
     *
     * @return bool
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function rename($path, $newPath): bool {
        $this->reconnectIfNotConnected();

        return $this->connection->rename($path, $newPath);
    }

    /**
     * @param $path
     * @param $newPath
     *
     * @return void
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FilesystemException
     */
    public function copy($path, $newPath) {
        $this->reconnectIfNotConnected();

        $this->connection->copy($path, $newPath);
    }

    /**
     * @param       $path
     * @param array $config
     *
     * @return bool
     */
    public function createDir($path, array $config = []): bool {
        $this->reconnectIfNotConnected();

        return $this->connection->createDir($path, $config);
    }


    /**
     * @param $path
     *
     * @return array|false
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getMetadata($path): false|array {
        $this->reconnectIfNotConnected();

        return $this->connection->getMetadata($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getMimetype($path): bool|string {
        $this->reconnectIfNotConnected();

        return $this->connection->getMimetype($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|int
     */
    public function getSize($path): bool|int {
        $this->reconnectIfNotConnected();

        return $this->connection->getSize($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getTimestamp($path): bool|string {
        $this->reconnectIfNotConnected();

        return $this->connection->getTimestamp($path);
    }

    /**
     * @param $path
     *
     * @return bool
     * @throws \League\Flysystem\FilesystemException
     */
    public function has($path) {
        $this->reconnectIfNotConnected();

        return $this->connection->has($path);
    }

    /**
     * @param string $path
     *
     * @return array
     * @throws \League\Flysystem\FilesystemException
     */
    public function listContents(string $path = ''): array {
        $this->reconnectIfNotConnected();

        return $this->connection->listContents($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FilesystemException
     */
    public function read($path): bool|string {
        $this->reconnectIfNotConnected();

        return $this->connection->read($path);
    }

    /**
     * @param $path
     *
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function readAndDelete($path): bool|string {
        $this->reconnectIfNotConnected();

        return $this->connection->readAndDelete($path);
    }

    /**
     * @param       $path
     * @param       $content
     * @param array $config
     *
     * @return bool
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function update($path, $content, array $config = []): bool {
        $this->reconnectIfNotConnected();

        return $this->connection->update($path, $content, $config);
    }


}
