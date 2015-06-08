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
                    'deploy_id'   => $deploy_id,
                    'record_type' => $record->type_firstdeploy,
                    'branch_id'   => $v['id'],
                    'date'        => time(),
                    'triggerby'   => '',
                    'status'      => $record->in_queue,
                ), $user_id);
        }

        $gfcore = new Gfcore($deploy_id);
        $gfcore->deploy();
    }

    public static function hook_run() {

    }

    public static function manual_run() {

    }

    public static function deploy_branch($branch_id) {

        $user_id = Auth::get_user_id()[1];
        $record = new Model_Record();
        $branch = new Model_Branch();

        $branches = $branch->get_by_branch_id($branch_id, array(
            'id',
            'auto',
            'deploy_id'
        ));

        if (count($branches) == 1) {
            $branches = $branches[0];
            $record_id = $record->insert(array(
                'deploy_id'   => $branches['deploy_id'],
                'record_type' => $record->type_manual,
                'branch_id'   => $branches['id'],
                'date'        => time(),
                'triggerby'   => '',
                'status'      => $record->in_queue
            ), $user_id);
            $gfcore = new Gfcore($branches['deploy_id']);
            $gfcore->deploy();

        } else {
            throw new Exception('No branch found.');
        }

    }
}
