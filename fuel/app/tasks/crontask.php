<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;

/**
 * Class Crontask
 * @package Fuel\Tasks
 *
 * Base start here.
 */
class Crontask {
    /**
     * NOT USED YET.
     * Iterates through all deploy, finding which one is not deployed, and starts its deployment.
     */
    public function deploy_all() {
        $deploy = new \Model_Deploy();
        $record = new \Model_Record();

        $projects = $deploy->get(NULL, array('id', 'cloned'), TRUE);
        foreach ($projects as $project) {
            $deploy_id = $project['id'];
            $is_active = $record->is_queue_active($deploy_id);
            if ($is_active) {
                continue;
            } else {
                \Gfcore::deploy_in_bg($deploy_id);
            }
        }
    }

    /**
     * Actual function that is called from CLI.
     * @param null $deploy_id
     * @return string
     * @throws \Exception
     */
    public function deploy($deploy_id) {
        Cli::write('ENVIRONMENT: '.\Fuel::$env);
        Cli::write("Starting with $deploy_id");
        $gfcore = new \Gfcore($deploy_id);
        $gfcore->deploy();
        $this->output('RAM USED: '.\Utils::humanize_data(memory_get_usage(true)));
        Cli::beep();
    }

    /**
     * Actual function that is called from CLI.
     * @param null $deploy_id
     * @return string
     * @throws \Exception
     */
    public function deploy2($deploy_id) {
        \Cli::write('ENVIRONMENT: '.\Fuel::$env);
        \Cli::write("Starting with $deploy_id");
        $gfcore = new \Deploy($deploy_id);
        $gfcore->init();
        \Cli::write('RAM USED: '.\Utils::humanize_data(memory_get_usage(true)));
        \Cli::beep();
    }

}