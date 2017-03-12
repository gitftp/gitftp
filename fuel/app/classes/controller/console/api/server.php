<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Record;

class Controller_Console_Api_Server extends Controller_Console_Authenticate {

    public function post_view () {
        try {
            $server_id = Input::json('server_id', false);
            $project_id = Input::json('project_id', false);

            $select = [
                'id',
                'name',
                'project_id',
                'branch',
                'type',
                'secure',
                'host',
                'port',
                'username',
                'path',
                'auto_deploy',
                'created_at',
                'updated_at',
            ];

            if ($server_id) {
                $servers = \Gf\Server::get_one([
                    'id' => $server_id,
                ], $select);
            } elseif ($project_id) {
                $servers = \Gf\Server::get([
                    'project_id' => $project_id,
                ], $select);
            } else {
                throw new UserException('Missing parameters');
            }

            $r = [
                'status' => true,
                'data'   => $servers,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

    public function post_create () {
        try {
            $name = Input::json('server.name', false);
            $branch = Input::json('server.branch', false);
            $auto_deploy = Input::json('server.auto_deploy', false);
            $type = Input::json('server.type', false);
            $host = Input::json('server.host', false);
            $port = Input::json('server.port', false);
            $username = Input::json('server.username', false);
            $password = Input::json('server.password', false);
            $path = Input::json('server.path', '');
            $secure = Input::json('server.secure', false);
            $project_id = Input::json('project_id', false);
            $edit_password = Input::json('server.edit_password', false);
            $id = Input::json('server.id', false);

            if (!$name or !$branch or !$type or !$project_id)
                throw new UserException('Missing parameters');

            if ($type == \Gf\Server::type_ftp or $type == \Gf\Server::type_sftp) {
                if (!$host or !$port or !$username or !$project_id)
                    throw new UserException('Missing parameters');
                if (!$id and !$password)
                    throw new UserException('Missing parameters');
            }

            $set = [
                'name'        => $name,
                'project_id'  => $project_id,
                'branch'      => $branch,
                'type'        => $type,
                'path'        => $path,
                'added_by'    => $this->user_id,
                'auto_deploy' => !!$auto_deploy,
            ];
            if ($type == \Gf\Server::type_ftp) {
                $set['secure'] = !!$secure;
                $set['host'] = $host;
                $set['port'] = $port;
                $set['username'] = $username;

                if ($edit_password)
                    $set['password'] = $password;
            }
            if ($type == \Gf\Server::type_sftp) {
                $set['secure'] = 0;
                $set['host'] = $host;
                $set['port'] = $port;
                $set['username'] = $username;

                if ($edit_password)
                    $set['password'] = $password;
            }
            if ($type == \Gf\Server::type_local) {
                $set['password'] = null;
                $set['secure'] = 0;
                $set['host'] = null;
                $set['port'] = null;
                $set['username'] = null;
            }


            if ($id) {
                $server_id = \Gf\Server::update([
                    'id' => $id,
                ], $set);
            } else {
                $server_id = \Gf\Server::insert($set);
            }


            $r = [
                'status' => true,
                'data'   => $server_id,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }


    public function post_test () {
        try {
            $server = Input::json('server');
            $writeTest = Input::json('writeTest', true);

            if ($server['type'] == \Gf\Server::type_ftp or $server['type'] == \Gf\Server::type_sftp) {
                if (!$server['edit_password'] and $server['id']) {
                    $ser = \Gf\Server::get_one([
                        'id' => $server['id'],
                    ], ['password']);
                    if (!$ser)
                        throw new UserException('The server does not exists');
                    $server['password'] = $ser['password'];
                }
            }
            if (!isset($server['path']) or !$server['path'])
                $server['path'] = '';

            $connection = \Gf\Deploy\Connection::instance($server)->connection();

            try {
                $contents = $connection->listContents();

                $empty = true;
                if (count($contents))
                    $empty = false;

                if ($writeTest) {
                    $s = $connection->put('gitftp_test_file.txt', 'This is a test file, its safe to delete it.');
                    if (!$s)
                        throw new UserException('Could not write to Deploy path, please grant permissions');

                    $s = $connection->delete('gitftp_test_file.txt');
                    if (!$s)
                        throw new UserException('Could not delete test file from deploy path, please grant permissions');
                }
            } catch (Exception $e) {
                throw new UserException($e->getMessage());
            }

            $r = [
                'status' => true,
                'data'   => [
                    'empty'       => $empty,
                    'directories' => $contents,
                ],
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }
}
