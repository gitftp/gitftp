<?php

use Craftpip\ProcessHandler\ProcessHandler;
use Gf\Deploy\Helper\DeployLife;

class Controller_Async extends \Fuel\Core\Controller {

    public function get_project ($project_id) {
        $this->project_using_process_lock($project_id);
    }

    private function project_using_file_lock ($project_id) {
        $isWorking = DeployLife::isLocked($project_id);
        if ($isWorking)
            die('Deploy is working, project is locked');

        echo "Starting deploy for project $project_id";
        try {
            DeployLife::lock($project_id);
            $deploy = \Gf\Deploy\Deploy::instance($project_id);
            $deploy->processProjectQueue(true);
            DeployLife::unlock($project_id);
        } catch (\Exception $e) {
            DeployLife::unlock($project_id);
            \Fuel\Core\Log::error($e->getMessage());
            \Gf\Exception\ExceptionInterceptor::intercept($e);
        }
    }

    private function project_using_process_lock ($project_id) {
        $d = DOCROOT;
        $p = PHP_BINDIR;
        $c = "${p}/php ${d}oil r deploy:project_using_process_lock $project_id";
        $process = new \Symfony\Component\Process\Process($c);
        $process->run();
        $process->setIdleTimeout(0);
        $process->setTimeout(0);
        echo $process->getOutput();
        echo $process->getErrorOutput();
    }

}
