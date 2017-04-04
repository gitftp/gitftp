<?php

use Gf\Deploy\Helper\DeployLife;

class Controller_Async extends \Fuel\Core\Controller {

    public function get_project2 ($project_id) {
        $d = DOCROOT;
        $process = new \Symfony\Component\Process\Process("php ${d}oil r deploy:project 12");
        $a = \Symfony\Component\Process\PhpProcess::$exitCodes;
        $a = $process->start();
        echo $process->isRunning();
        echo '<br>';
        echo $process->getPid();
        echo '<br>';
        echo $process->getOutput();
    }

    public function get_project ($project_id) {
        try {
            $isWorking = DeployLife::isWorking($project_id);
            if ($isWorking)
                throw new \Gf\Exception\UserException('The deploy is working');

            DeployLife::working($project_id);
            $deploy = \Gf\Deploy\Deploy::instance($project_id);
            $deploy->processProjectQueue(true);
            DeployLife::doneWorking($project_id);
        } catch (\Exception $e) {
            DeployLife::doneWorking($project_id);
            \Fuel\Core\Log::error($e->getMessage());
            \Gf\Exception\ExceptionInterceptor::intercept($e);
        }
    }
}
