<?php

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Config;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

    public function post_create () {
        try {

            $repository_id = Input::json('project.repo.id');
            $repository_provider = Input::json('project.repo.provider');
            $repository_full_name = Input::json('project.repo.full_name');
            $branches = Input::json('project.branches');

            if (!$repository_id or !$repository_provider or !$repository_full_name or !$branches)
                throw new \Gf\Exception\UserException('Missing parameters');

            $project_id = \Gf\Projects::create($repository_id, $repository_provider, $repository_full_name, $this->user_id);

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
            $git = new \Gf\Git\Git($this->user_id);
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
                throw new \Gf\Exception\UserException('Missing parameters');

            list($username, $repository_name) = explode('/', $full_name);

            $git = new \Gf\Git\Git($this->user_id, $provider);
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
