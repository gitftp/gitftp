<?php
namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\Fuel;
use Gf\Deploy\Helper\DeployLife;
use Gf\Exception\UserException;
use Gf\Utils;

/**
 * Class Deploy
 *
 * @package Fuel\Tasks
 */
class Deploy {

    public function project ($project_id) {
        Cli::write('Env: ' . Fuel::$env);
        Cli::write("Starting with $project_id");

        $isWorking = DeployLife::isWorking($project_id);
        if ($isWorking)
            throw new UserException('The deploy is working');

        DeployLife::working($project_id);
        $deploy = \Gf\Deploy\Deploy::instance($project_id);
        $deploy->processProjectQueue(true);
        DeployLife::doneWorking($project_id);
        $deploy = \Gf\Deploy\Deploy::instance($project_id);
        $deploy->processProjectQueue(true);

        Cli::write('RAM USED: ' . Utils::humanize_data(memory_get_usage(true)));
    }
}