<?php

class Controller_Async extends Controller {
    public function get_project ($project_id) {
        try {

            $deploy = \Gf\Deploy\Deploy::instance($project_id);
            $deploy->processProjectQueue(true);

        } catch (Exception $e) {
            \Fuel\Core\Log::error($e->getMessage());
            \Gf\Exception\ExceptionInterceptor::intercept($e);
        }
    }
}
