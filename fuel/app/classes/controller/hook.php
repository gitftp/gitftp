<?php

class Controller_Hook extends Controller {

    public function action_index() {
        echo '';
    }

    public function action_i($user_id = NULL, $deploy_id = NULL, $key = NULL) {
        if (Input::method() != 'POST')
            die('Invalid method. This API only supports POST requests');

        if ($user_id == NULL)
            die('User id is missing, please refer to documentation.');

        if ($deploy_id == NULL)
            die('Project ID is missing, please refer to documentation.');

        if ($key == NULL)
            die('Project hook key missing, please refer to documentation.');

        $deploy = new Model_Deploy();
        $deploy->user_id = $user_id;
        $repo = $deploy->get($deploy_id, NULL);

        if (count($repo) == 0) {
            die('The project was not found, please refer to documentation.');
        } else {
            if ($key != $repo[0]['key']) {
                die('The project and key do not match, please refer to documentation.');
            }
            if ($repo[0]['cloned'] == 0) {
                die('The project is not yet been initialized. please manually deploy first.');
            }
            if ($repo[0]['active'] == 0) {
                die('Sorry, cannot deploy this project for the moment, please contact support.');
            }
        }

        utils::log($_POST['payload']);
        utils::log(serialize($repo));

        $repo = $repo[0];
        $parsedPayload = utils::parsePayload($_REQUEST, $deploy_id);

        utils::log(serialize($parsedPayload));
        $record = new Model_Record();
        $record->user_id = $user_id;
        $branch = new Model_Branch();
        $branch->user_id = $user_id;

        // getting environments to deploy.
        $branches = $branch->get_by_branch_name($parsedPayload['branch']);

        foreach ($branches as $branchSingle) {
            if ($branchSingle['auto'] == 0){
                echo 'Environemnt auto-deploy is disabled.';
                continue;
            }
            if($branchSingle['ready'] == 0){
                echo 'Environemnt not ready, please deploy first.';
                continue;
            }

            $record->insert(array(
                'deploy_id'      => $branchSingle['deploy_id'],
                'record_type'    => $record->type_service_push,
                'branch_id'      => $branchSingle['id'],
                'date'           => time(),
                'status'         => $record->in_queue,
                'triggerby'      => $parsedPayload['user'],
                'post_data'      => $parsedPayload['post_data'],
                'avatar_url'     => $parsedPayload['avatar_url'],
                'hash'           => $parsedPayload['hash'],
                'commit_count'   => $parsedPayload['commit_count'],
                'commit_message' => $parsedPayload['commit_message']
            ));
        }

//        Gfcore::deploy_in_bg($deploy_id);
    }

    public function action_get() {
        echo '<pre>';
        $a = DB::select()->from('test')->execute()->as_array();
        print_r(json_decode(unserialize($a[1]['test'])['payload']));
//        print_r(json_decode(unserialize($a[1]['payload'])));
    }

    public function action_put() {
        DB::insert('test')->set(array(
            'test' => serialize($_REQUEST)
        ))->execute();
    }

    public function action_test() {
        $a = 'asdasdasdgithub.comet.com sdasdasd';

        if (preg_match('/bitbucket.com/i', $a)) {
            $service = 'bitbucket';
        }
        if (preg_match('/github.com/i', $a)) {
            $service = 'github';
        }
        echo $service;
    }


}
