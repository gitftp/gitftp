<?php

use Fuel\Core\Input;
use Gf\Config;

class Controller_Console_Api_Projects extends Controller_Console_Authenticate {

    public function post_list_available_repositories () {
        try {
            $git = new \Gf\Git\Git($this->user_id);
            $list = $git->getRepositories();
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
