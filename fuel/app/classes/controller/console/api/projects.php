<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Record;
use Gf\Server;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

    public function post_delete () {
        try {
            $project_id = Input::json('project_id');
            if (!$project_id)
                throw new UserException('Missing parameters');

            Project::delete($project_id);

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

    public function post_create_hook () {
        try {
            $project_id = Input::json('project_id');
            if (!$project_id)
                throw new UserException('Missing parameters');

            $project = Project::get_one([
                'id' => $project_id,
            ]);
            if (!$project)
                throw new UserException('Project not found');

            $gitApi = \Gf\Git\GitApi::instance($this->user_id, $project['provider']);

            $existing_hook = $gitApi->api()->getHook($project['git_name'], $project['hook_id']);
            if ($existing_hook)
                throw new UserException('Hook already exists');

            if (!$project) {
                $project['hook_key'] = Str::random('alnum', 6);
                Project::update([
                    'id' => $project_id,
                ], [
                    'hook_key' => $project['hook_key'],
                ]);
            }

            $hook_url = $gitApi->createHookUrl($project_id, $project['hook_key'], $this->user_id);

            $response = $gitApi->api()->setHook($project['git_name'], $project['git_username'], $hook_url);

            if ($response) {
                $hook_id = $response['id'];
                Project::update([
                    'id' => $project_id,
                ], [
                    'hook_id' => $hook_id,
                ]);
            }

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

    public function post_check_hook () {
        try {
            $project_id = Input::json('project_id');
            if (!$project_id)
                throw new UserException('Missing parameters');

            $project = Project::get_one([
                'id' => $project_id,
            ]);
            if (!$project)
                throw new UserException('Project not found');

            $gitApi = \Gf\Git\GitApi::instance($this->user_id, $project['provider']);
            $hook = $gitApi->api()->getHook($project['git_name'], $project['hook_id']);

            if (!$hook) {
                $hookExists = false;
            } else {
                $hookExists = true;
            }

            $r = [
                'status' => true,
                'data'   => $hookExists,
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

    public function post_pull_changes () {
        $project_id = Input::json('project_id');
        if (!$project_id)
            throw new UserException('Missing parameters');

        try {
            $project = Project::get_one([
                'id' => $project_id,
            ]);
            if (!$project)
                throw new UserException('The project was not found');

            $af = Project::update([
                'id' => $project_id,
            ], [
                'pull_state' => Project::pull_state_pulling,
            ]);

            $repoPath = Project::getRepoPath($project_id);
            $gitLocal = \Gf\Git\GitLocal::instance($repoPath);
            $gitLocal->pull($project['owner_id'], $project['provider'], $project['clone_uri']);

            $af = Project::update([
                'id' => $project_id,
            ], [
                'pull_state' => Project::pull_state_pulled,
            ]);

            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {

            $af = Project::update([
                'id' => $project_id,
            ], [
                'pull_state' => Project::pull_state_pulled,
            ]);

            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }
        $this->response($r);
    }

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

            $gitApi = \Gf\Git\GitApi::instance($this->user_id, $project['provider']);
            $revisions = $gitApi->api()->commits($project['git_name'], $branch, $project['git_username']);

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

            $project = Project::get_one([
                'id' => $project_id,
            ], [
                'id',
                'clone_state',
            ]);

            if (!$project)
                throw new UserException('Project not found');

            if ($project['clone_state'] != Project::clone_state_not_cloned) {
                throw new UserException('The clone is running or has been cloned');
            }

            $id = Record::insert([
                'type'       => Record::type_clone,
                'server_id'  => null,
                'project_id' => $project_id,
                'status'     => Record::status_new,
            ]);

            \Gf\Utils::asyncCall('project', $project_id);

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

    public function post_record_status () {
        try {
            $record_id = Input::json('record_id', false);
            $r = Record::get_one([
                'id' => $record_id,
            ], [
                'edited_files',
                'added_files',
                'deleted_files',
                'total_files',
                'processed_files',
                'status',
                'log_file',
            ]);

            $r = [
                'status' => true,
                'data'   => $r,
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
            $offset = Input::json('offset', false);

            if (!$project_id)
                throw new UserException('Missing parameters');

            $record_table = Record::table;
            $server_table = Server::table;

            $offset_query = 0;
            if ($offset)
                $offset_query = $offset;

            $server_id_query = '';
            if ($server_id)
                $server_id_query = " and records.server_id = $server_id";

            $query = "
            SELECT records.*, 
            servers.name
            FROM records
            LEFT JOIN servers
            ON servers.id = records.server_id
            WHERE records.project_id = $project_id
            $server_id_query
            ORDER BY records.id desc
            LIMIT 30
            OFFSET $offset_query
            ";

            $records = \DB::query($query)->execute(Project::db)->as_array();

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
                'pull_state',
                'last_updated',
                'git_username',
                'status',
            ];

            if ($id) {
                $where['id'] = $id;
                $project = Project::get_one($where, $select);
            } else {
                $project = Project::get($where, $select);

                foreach ($project as $k => $p) {
                    $servers = Server::get([
                        'project_id' => $p['id'],
                    ], [
                        'id',
                        'name',
                        'branch',
                        'type',
                        'auto_deploy',
                        'revision',
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
            $git = \Gf\Git\GitApi::instance($this->user_id);
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

            $git = \Gf\Git\GitApi::instance($this->user_id, $provider);
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
