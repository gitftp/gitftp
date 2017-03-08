<?php

use Fuel\Core\Input;
use Gf\Config;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

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
