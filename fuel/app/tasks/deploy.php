<?php
namespace Fuel\Tasks;

use Craftpip\ProcessHandler\ProcessHandler;
use Fuel\Core\Cli;
use Fuel\Core\Fuel;
use Gf\Deploy\Helper\DeployLife;
use Gf\Exception\UserException;
use Gf\Project;
use Gf\Utils;

/**
 * Class Deploy
 *
 * @package Fuel\Tasks
 */
class Deploy {

    public function project_using_file_lock ($project_id) {
        Cli::write("Starting with $project_id");

        $isWorking = DeployLife::isLocked($project_id);
        if ($isWorking)
            throw new UserException('The deploy is working');

        try {
            DeployLife::lock($project_id);
            $deploy = \Gf\Deploy\Deploy::instance($project_id);
            $deploy->processProjectQueue(true);
        } catch (\Exception $e) {
            Cli::write($e->getMessage());
        }

        DeployLife::unlock($project_id);

        Cli::write('RAM USED: ' . Utils::humanize_data(memory_get_usage(true)));
    }

    public function project_using_process_lock ($project_id) {
        Cli::write("Starting with $project_id");
        $project = Project::get_one([
            'id' => $project_id,
        ], [
            'deploy_pid',
        ]);
        if (!$project)
            throw new UserException("The project with id $project_id was not found");

        $pid = $project['deploy_pid'];
        Cli::write("Current Pid $pid");
        $process = [];
        if (!is_null($pid)) {
            $processHandler = new ProcessHandler();
            $process = $processHandler->api->getProcessByPid($pid);
            Cli::write("Process exists " . json_encode($process));
        }

        if ($pid and count($process)) {
            // the process is still running.
            Cli::write("Process is running");
        } else {
            $new_pid = getmypid();
            Cli::write("New pid: $new_pid");
            $af = Project::update([
                'id' => $project_id,
            ], [
                'deploy_pid' => $new_pid,
            ]);

            try {
                $deploy = \Gf\Deploy\Deploy::instance($project_id);
                $deploy->processProjectQueue(true);
            } catch (\Exception $e) {
                Cli::write($e->getMessage());
            }

            Project::update([
                'id' => $project_id,
            ], [
                'deploy_pid' => null,
            ]);
        }

        Cli::write('RAM USED: ' . Utils::humanize_data(memory_get_usage(true)));

        echo '<br>';
        echo time();

    }
}