<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Record;

class Controller_Console_Api_Server extends Controller_Console_Authenticate {

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
            $path = Input::json('server.path', false);
            $secure = Input::json('server.secure', false);
            $project_id = Input::json('project_id', false);

            if (!$name or !$branch or !$type or !$host or !$port or !$username
                or !$password or !$path or !$project_id
            )
                throw new UserException('Missing parameters');

            $server_id = \Gf\Server::insert([
                'name'        => $name,
                'project_id'  => $project_id,
                'branch'      => $branch,
                'type'        => $type,
                'secure'      => !!$secure,
                'host'        => $host,
                'port'        => $port,
                'username'    => $username,
                'password'    => $password,
                'path'        => $path,
                'added_by'    => $this->user_id,
                'auto_deploy' => !!$auto_deploy,
            ]);

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
            $connection = \Gf\Deploy\Connection::instance($server)->connection();

            try {
                $contents = $connection->listContents();
                $empty = true;
                if (count($contents))
                    $empty = false;

                $s = $connection->put('gitftp_test_file.txt', 'This is a test file, its safe to delete it.');
                if (!$s)
                    throw new UserException('Could not write to Deploy path, please grant permissions');

                $s = $connection->delete('gitftp_test_file.txt');
                if (!$s)
                    throw new UserException('Could not delete test file from deploy path, please grant permissions');
            } catch (Exception $e) {
                throw new UserException($e->getMessage());
            }

            $r = [
                'status' => true,
                'data'   => [
                    'empty' => $empty,
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
