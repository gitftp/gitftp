<?php

use Gf\Deploy\Helper\DeployLife;

class Controller_Async extends Controller {
    public function get_project ($project_id) {
        try {
            $isWorking = DeployLife::isWorking($project_id);
            if ($isWorking)
                throw new \Gf\Exception\UserException('The deploy is working');

            DeployLife::working($project_id);
            $deploy = \Gf\Deploy\Deploy::instance($project_id);
            $deploy->processProjectQueue(true);
            DeployLife::doneWorking($project_id);

        } catch (Exception $e) {
            \Fuel\Core\Log::error($e->getMessage());
            \Gf\Exception\ExceptionInterceptor::intercept($e);
        }
    }
}
