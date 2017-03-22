<?php

class Controller_Hook extends Controller {

    public function get_link ($user_id = null, $project_id = null, $key = null) {
        echo "This api receives notifications from Git providers when you push changes to the repository <br>Nothing much to do here.";
    }

    public function post_link ($user_id = null, $project_id = null, $key = null) {
        try {
            $data = \Fuel\Core\Input::json();
            if (!$user_id or !$project_id or !$key)
                throw new \Gf\Exception\UserException('Missing parameters');

            $project = \Gf\Project::get_one([
                'id'       => $project_id,
                'owner_id' => $user_id,
                'hook_key' => $key,
            ]);
            if (!$project)
                throw new \Gf\Exception\UserException("The project was not found");


            $r = [
                'status' => true,
            ];
        } catch (\Exception $e) {
            $e = \Gf\Exception\ExceptionInterceptor::intercept($e);
            $r = [
                'status' => false,
                'reason' => $e->getMessage(),
            ];
        }

        echo json_encode($r);
    }


    public function action_i ($user_id = null, $deploy_id = null, $key = null) {

        try {

            if (Input::method() != 'POST')
                die('Invalid method. This API only supports POST requests');

            if ($user_id == null)
                die('User id is missing, please refer to documentation.');

            if ($deploy_id == null)
                die('Project ID is missing, please refer to documentation.');

            if ($key == null)
                die('Project hook key missing, please refer to documentation.');

            $body = @file_get_contents('php://input');
            $fc = substr($body, 0, 1);
            if ($fc == '{' || $fc == '[') {
                // is json.
                $payload = json_decode($body, true);
            } else {
                die('Invalid header request. please refer to documentation.');
            }

            $deploy = new Model_Deploy();
            $deploy->user_id = $user_id;
            $repo = $deploy->get($deploy_id, null);

            if (count($repo) == 0) {
                die('The project was not found, please refer to documentation.');
            } else {
                if ($key != $repo[0]['key']) {
                    die('The project and key do not match, please refer to documentation.');
                }

//                if ($repo[0]['cloned'] == 0) {
//                    die('The project is not yet been initialized. please manually deploy first.');
//                }

                if ($repo[0]['active'] == 0) {
                    die('Sorry, This project is deactivated, please contact support.');
                }
            }

            $parsedPayload = Utils::parsePayload($payload);

            $record = new Model_Record();
            $record->user_id = $user_id;
            $branch = new Model_Branch();
            $branch->user_id = $user_id;

            // getting environments to deploy.
            $branches = $branch->get_by_branch_name_deploy_id($parsedPayload['branch'], $deploy_id);

            foreach ($branches as $branchSingle) {
                if ($branchSingle['auto'] == 0) {
                    echo 'Environment auto-deploy is disabled.';
                    continue;
                }
                if ($branchSingle['ready'] == 0) {
                    echo 'Environment not ready, please deploy first.';
                    continue;
                }

                $record->insert([
                    'deploy_id'   => $branchSingle['deploy_id'],
                    'record_type' => $record->type_service_push,
                    'branch_id'   => $branchSingle['id'],
                    'date'        => time(),
                    'status'      => $record->in_queue,
                    'triggerby'   => $parsedPayload['user'],
                    'post_data'   => $parsedPayload['post_data'],
                    'avatar_url'  => $parsedPayload['avatar_url'],
                    'hash'        => $parsedPayload['hash'],
                    'commits'     => $parsedPayload['commits'],
                ]);
            }

//            Gfcore::deploy_in_bg($deploy_id);
            \Utils::startDeploy($deploy_id);
        } catch (Exception $e) {
            \Utils::log($e->getMessage());
        }

    }

    /*
     * Logic ends here.
     */


    public function action_get () {
        echo '<pre>';
        $a = DB::select()->from('test')->execute()->as_array();
        print_r(json_decode(unserialize($a[1]['test'])['payload']));
//        print_r(json_decode(unserialize($a[1]['payload'])));
    }

    public function action_put () {
        DB::insert('test')->set([
            'test' => serialize($_REQUEST),
        ])->execute();
    }

    public function action_test () {
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
