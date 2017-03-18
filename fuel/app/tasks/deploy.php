<?php
namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Gf\Utils;

/**
 * Class Deploy
 *
 * @package Fuel\Tasks
 */
class Deploy {

    /**
     * @param $project_id
     */
    public function project ($project_id) {
        Cli::write('Env: ' . \Fuel::$env);
        Cli::write("Starting with $project_id");

        $deploy = \Gf\Deploy\Deploy::instance($project_id);
        $deploy->processProjectQueue(true);

        Cli::write('RAM USED: ' . Utils::humanize_data(memory_get_usage(true)));
    }
}