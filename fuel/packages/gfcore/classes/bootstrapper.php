<?php

class Bootstrapper {

    /**
     * Creates records to be deployed.
     *
     * @param $deploy_id
     */
    public static function first_run($deploy_id) {

        $user_id = Auth::get_user_id()[1];
        $record = new Model_Record();
        $branch = new Model_Branch();
        $branches = $branch->get($deploy_id, array(
            'id',
            'auto'
        )); // get only id.

        foreach ($branches as $k => $v) {
            if ($v)
                $record_id = $record->insert(array(
                    'deploy_id' => $deploy_id,
                    'user_id'   => $user_id,
                    'branch_id' => $v['id'],
                    // branch id to deploy
                    'date'      => time(),
                    // start time
                    'triggerby' => 'Manually (first deploy)',
                    // first deploy
                    'status'    => 3,
                    // in queue
                ));
        }

        $gfcore = new Gfcore($deploy_id);
        $gfcore->deploy();
    }

    public static function hook_run() {

    }

    public static function manual_run(){

    }
}
