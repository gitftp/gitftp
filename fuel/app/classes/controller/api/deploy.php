<?php

class Controller_Api_Deploy extends Controller_Apilogincheck {

    public function action_index() {
        echo 'what ?';
    }

    public function action_getbranches() {
        $post = Input::post();
        try {
            if (isset($post['deploy_id'])) {
                $deploy = new Model_Deploy();
                $data = $deploy->get($post['deploy_id']);

                if (count($data) !== 1)
                    throw new Exception('The project does not exist.');

                $repo = $data[0]['repository'];
                $username = $data[0]['username'];
                $password = $data[0]['password'];
            } else {
                $repo = $post['repo'];
                $username = $post['username'];
                $password = $post['password'];
            }

            $a = utils::gitGetBranches($repo, $username, $password);
            if ($a) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'data'    => $a,
                    'request' => $post
                ));
            } else {
                throw new Exception('Failed connecting to GIT server.');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $post
            ));
        }

    }

    /**
     * A LOT HAS LEFT HERE.
     */
    public function action_dashdata() {
        $deploy = new Model_Deploy();
        $user_id = Auth::get_user_id()[1];
        $dir = DOCROOT . 'fuel/repository/' . $user_id;
        $a = shell_exec("du -hs $dir");
        $a = explode('	', $a);
        $disk_usage_human = $a[0];
        $deploy_list = $deploy->get(NULL, array(
            'repository',
            'id',
            'status',
            'lastdeploy',
            'name',
        ));

        foreach ($deploy_list as $k => $v) {
            $id = $v['id'];
            $a = shell_exec("du -hs $dir/$id");
            $a = explode('	', $a);
            $deploy_list[$k]['size'] = $a[0];
        }

        echo json_encode(array(
            'status' => TRUE,
            'user'   => array(
                'diskused' => $disk_usage_human,
                'id'       => Auth::get_user_id()[1],
                'name'     => Auth::get_screen_name(),
                'email'    => Auth::get_email(),
                'avatar'   => utils::get_gravatar(Auth::get_email(), 40)
            ),
            'deploy' => $deploy_list,
        ));
    }

    public function action_getonly($id = NULL) {

        $a = Input::post();
        $deploy = new Model_Deploy();
        $a = explode(',', $a['select']);
        array_push($a, 'cloned');

        $b = $deploy->get(NULL, $a);
        echo json_encode(array(
            'status' => TRUE,
            'data'   => $b
        ));

    }

    public function action_getall($id = NULL) {
        $deploy = new Model_Deploy();
        $branches = new Model_Branch();
        $record = new Model_Record();
        $a = $deploy->get($id);
        foreach ($a as $k => $v) {
            $b = $branches->get($id);
            foreach ($b as $k2 => $v2) {
                $r = $record->get_latest_revision_by_branch_id($b[$k2]['id']);
                if (count($r)) {
                    $b[$k2]['date'] = $r[0]['date'];
                }
            }
            $a[$k]['branches'] = $b;
        }

        echo json_encode(array(
            'status' => TRUE,
            'data'   => utils::strip_passwords($a)
        ));

    }

    public function action_delete($id = NULL) { // deploy id.
        $record = new Model_Record();
        $is_active = $record->is_queue_active($id);

        if ($is_active) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => 'Deployment is in progress, please try again later.'
            ));

            return FALSE;
        }
        $deploy = new Model_Deploy();

        try {
            $answer = $deploy->delete($id);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => $e->getMessage() . '' . $e->getLine()
            ));

            return FALSE;
        }

        if ($answer) {
            echo json_encode(array(
                'status'  => TRUE,
                'request' => $id,
            ));
        } else {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => $id,
                'reason'  => $answer,
            ));
        }

    }

    public function action_new() {

        $i = Input::post();

        $deploy = new Model_Deploy();
        $deploy_id = $deploy->create($i['repo'], $i['name'], $i['username'], $i['password'], $i['key'], $i['env']);

        if ($deploy_id) {
            echo json_encode(array(
                'status'  => TRUE,
                'request' => $i
            ));
        } else {
            echo json_encode(array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $deploy_id,
            ));
        }
    }

    public function post_edit($id) {

        $i = Input::post();
        $i = utils::escapeHtmlChars($i);

        $user_id = Auth::get_user_id()[1];
        $deploy = new Model_Deploy();
        $deploy_row = $deploy->get($id)[0];

        try {
            if ((string)$deploy_row['user_id'] !== (string)$user_id) {
                throw new Exception('404. Project not found.');
            }

            $data = array(
                'name' => $i['name'],
                'key'  => $i['key'],
            );

            if (isset($i['isprivate'])) {
                /*
                 * if private feed username and password
                 */
                if (isset($i['username']))
                    $data['username'] = $i['username'];
                if (isset($i['password']))
                    $data['password'] = $i['password'];

            } else {
                /*
                 * if not private remove username and password.
                 */
                $data['username'] = '';
                $data['password'] = '';
            }

            $result = $deploy->set($id, $data);

            if ($result[1] !== 0) {

                // changing clone url in git.
                $deploy_row2 = $deploy->get($id)[0];
                $repo_url = $deploy_row2['repository'];
                $repo_url = parse_url($repo_url);

                if (!empty($deploy_row2['username'])) {
                    $repo_url['user'] = $deploy_row2['username'];
                    if (!empty($deploy_row2['password'])) {
                        $repo_url['pass'] = $deploy_row2['password'];
                    }
                }

                $newCloneUrl = http_build_url($repo_url);
                $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deploy_row2['id'];

                try {
                    chdir($repo_dir);
//                    echo $newCloneUrl;
                    // TODO: this is not working !
                    $op = utils::gitCommand('remote set-url origin '.$newCloneUrl);
//                    exec('git remote set-url origin ' . $newCloneUrl, $op);
//                    print_r($op);
                } catch (Exception $e) {
                    // if the folder doesnt exist, do nothing.
                }

                $response = json_encode(array(
                    'status'  => TRUE,
                    'request' => $i
                ));
            } else {
                throw new Exception('Failed to update deploy configuration, please try again.');
            }

        } catch (Exception $e) {
            $response = json_encode(array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $e->getMessage()
            ));
        }

        return $response;
    }

    /*
     * Run the deploy for a given branch.
     */
    public function post_run() {
        $i = Input::post();

        try {
            if (!isset($i['deploy_id']))
                throw new Exception('Missing parameter.');

            $record = new Model_Record();
            $branch = new Model_Branch();
            $deploy = new Model_Deploy();
            $deploy_id = $i['deploy_id'];

            if (isset($i['branch_id'])) {
                $branches = $branch->get_by_branch_id($i['branch_id'], array(
                    'id',
                    'auto',
                    'deploy_id'
                ));
            } else {
                $branches = $branch->get($deploy_id, array(
                    'id',
                    'auto',
                    'deploy_id'
                ));
            }

            if (count($branches) > 0) {
                foreach ($branches as $singlebranch) {
                    $record_id = $record->insert(array(
                        'deploy_id'   => $deploy_id,
                        'record_type' => $record->type_manual,
                        'branch_id'   => $singlebranch['id'],
                        'date'        => time(),
                        'triggerby'   => '',
                        'status'      => $record->in_queue,
                    ));
                }
            }

//            Gfcore::deploy_in_bg($deploy_id);
            echo json_encode(array(
                'status' => TRUE,
            ));

        } catch (Exception $e) {
            echo json_encode(array(
                'status' => FALSE,
                'reason' => $e->getMessage() . $e->getLine() . $e->getFile()
            ));
        }

    }
}
