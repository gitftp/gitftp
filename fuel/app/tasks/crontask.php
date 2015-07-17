<?php
namespace Fuel\Tasks;

/**
 * Class Crontask
 * @package Fuel\Tasks
 *
 * Base start here.
 */
class Crontask {

    /**
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
        $gfcore = new \Gfcore($deploy_id);
        $gfcore->deploy();


        \Cli::beep();
    }

    /**
     * Excecution time test
     */
    public function time(){
        echo \Cli::color('Error: The universe is broken.', 'red');
        \Cli::beep();
    }
}