<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Record;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

    public function post_revisions () {
        try {
            $project_id = Input::json('project_id', false);
            $branch = Input::json('branch', false);
            if (!$project_id or !$branch)
                throw new UserException('Missing parameters');

            $project = Project::get_one([
                'id' => $project_id,
            ]);
            if (!$project)
                throw new UserException('The project does not exists');

            $gitApi = new \Gf\Git\GitApi($this->user_id, $project['provider']);
            $revisions = $gitApi->api()->commits($project['git_name'], 'master', $project['git_username']);

            $r = [
                'status' => true,
                'data'   => $revisions,
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

    public function post_clone () {
        try {
            $project_id = Input::json('project_id', false);
            if (!$project_id)
                throw new UserException('Missing parameters');

            $projectExists = Project::get_one([
                'id' => $project_id,
            ], [
                'id',
            ]);

            if (!$projectExists)
                throw new UserException('Project not found');

            $id = Record::insert([
                'type'       => Record::type_clone,
                'server_id'  => null,
                'project_id' => $project_id,
                'status'     => Record::status_new,
            ]);

            \Gf\Deploy\Deploy::instance($project_id)->processRecord($id);

            $r = [
                'status' => true,
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

    public function post_records () {
        try {
            $server_id = Input::json('server_id', false);
            $project_id = Input::json('project_id', false);

            if (!$project_id)
                throw new UserException('Missing parameters');

            $where = [
                'project_id' => $project_id,
            ];

            if ($server_id)
                $where['server_id'] = $server_id;

            $records = Record::get($where);

            if (!$records)
                $records = [];

            $r = [
                'status' => true,
                'data'   => [
                    'list'  => $records,
                    'total' => count($records),
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

    public function post_view () {
        try {
            $id = Input::json('project_id', false);

            $where = [
                'owner_id' => $this->user_id,
            ];

            $select = [
                'id',
                'name',
                'uri',
                'git_name',
                'created_at',
                'provider',
                'clone_state',
                'status',
            ];

            if ($id) {
                $where['id'] = $id;
                $project = Project::get_one($where, $select);
            } else {
                $project = Project::get($where, $select);

                foreach ($project as $k => $p) {
                    $servers = \Gf\Server::get([
                        'project_id' => $p['id'],
                    ], [
                        'id',
                        'name',
                        'branch',
                        'type',
                        'auto_deploy',
                    ]);
                    if (!$servers)
                        $servers = [];

                    $p['servers'] = $servers;
                    $project[$k] = $p;
                }
            }

            $r = [
                'status' => true,
                'data'   => $project,
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

            $repository_id = Input::json('project.repo.id');
            $repository_provider = Input::json('project.repo.provider');
            $repository_full_name = Input::json('project.repo.full_name');
            $branches = Input::json('project.branches');

            if (!$repository_id or !$repository_provider or !$repository_full_name or !$branches)
                throw new UserException('Missing parameters');

            $project_id = Project::create($repository_id, $repository_provider, $repository_full_name, $this->user_id);

            $r = [
                'status' => true,
                'data'   => $project_id,
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

    public function post_list_available_repositories () {
        try {
            $git = new \Gf\Git\GitApi($this->user_id);
            $list = $git->getCombinedRepositories();
            $r = [
                'status' => true,
                'data'   => $list,
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

    public function post_list_available_branches () {
        try {
            $project_id = Input::json('project_id', false);
            $provider = Input::json('repository.provider', false);
            $full_name = Input::json('repository.full_name', false);

            if ($project_id) {
                $project = Project::get_one([
                    'id' => $project_id,
                ]);
                $username = $project['git_username'];
                $repository_name = $project['git_name'];
                $provider = $project['provider'];
            } else {
                if (!$provider or !$full_name)
                    throw new UserException('Missing parameters');

                list($username, $repository_name) = explode('/', $full_name);
            }

            $git = new \Gf\Git\GitApi($this->user_id, $provider);
            $list = $git->api()->getBranches($repository_name, $username);

            $r = [
                'status' => true,
                'data'   => $list,
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
