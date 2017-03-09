<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Record;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

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
            ]);

            \Gf\Deploy\Deploy::instance()->clone($project_id);

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

            $project = Project::get_one([
                'id'       => $id,
                'owner_id' => $this->user_id,
            ]);

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
            $provider = Input::json('repository.provider', false);
            $full_name = Input::json('repository.full_name', false);
            if (!$provider or !$full_name)
                throw new UserException('Missing parameters');

            list($username, $repository_name) = explode('/', $full_name);

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
