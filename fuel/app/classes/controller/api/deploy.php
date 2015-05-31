<?php

class Controller_Api_Deploy extends Controller_Apilogincheck {

    public function action_index() {
        echo 'what ?';
    }

    public function action_getbranches() {
        $post = Input::post();
        $a = utils::gitGetBranches($post['repo'], $post['username'], $post['password']);
        if ($a) {
            echo json_encode(array(
                'status'  => TRUE,
                'data'    => $a,
                'request' => $post
            ));
        } else {
            echo json_encode(array(
                'status'  => FALSE,
                'reason'  => 'Could not connect',
                'request' => $post
            ));
        }
    }

    public function action_dashdata() {
        $deploy = new Model_Deploy();
        $user_id = Auth::get_user_id()[1];
        $dir = DOCROOT . 'fuel/repository/' . $user_id;
        $a = shell_exec("du -hs $dir");
        $a = explode('	', $a);
        $disk_usage_human = $a[0];
        $deploy_list = $deploy->get(null, array(
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

    public function action_getonly($id = null) {

        $a = Input::post();
        $deploy = new Model_Deploy();
        $a = explode(',', $a['select']);
        array_push($a, 'cloned');

        $b = $deploy->get(null, $a);
        echo json_encode(array(
            'status' => TRUE,
            'data'   => $b
        ));

    }

    public function action_getall($id = null) {

        $deploy = new Model_Deploy();
        $branches = new Model_Branch();
        $record = new Model_Record();
        $a = $deploy->get($id);
        foreach ($a as $k => $v) {
            $b = $branches->get($id);
            foreach ($b as $k2 => $v2) {
                $r = $record->get_latest_revision_by_branch_id($b[$k2]['id']);
                if (count($r)) {
                    $b[$k2]['revision'] = $r[0]['hash'];
                    $b[$k2]['date'] = $r[0]['date'];
                    $b[$k2]['date'] = $r[0]['date'];
                }
            }
            $a[$k]['branches'] = $b;
        }
        echo json_encode(array(
            'status' => TRUE,
            'data'   => $a
        ));

    }

    public function action_delete($id = null) {

        $deploy = new Model_Deploy();
        $answer = $deploy->delete($id);

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

    public function action_edit($id) {

        $i = Input::post();
        $user_id = Auth::get_user_id()[1];

        /*
         * FTP setup,
         * initial revision to empty.
         */
        $a = DB::select()->from('deploy')->where('id', $id)->execute()->as_array();
        if ($a[0]['user_id'] == $user_id) {

            $ftp = unserialize($a[0]['ftp']);
            $ftp['production'] = $i['ftp-production'];

            $b = DB::update('deploy')->set(array(
                'repository' => $i['repo'],
                'name'       => $i['name'],
                'username'   => (empty($i['username'])) ? '' : $i['username'],
                'password'   => (empty($i['password'])) ? '' : $i['password'],
                'key'        => $i['key'],
                'ftp'        => serialize($ftp)
            ))->where('id', $id)->execute();

            if ($b[1] !== 0) {
                echo json_encode(array(
                    'status'  => TRUE,
                    'request' => $i
                ));
            } else {

                echo json_encode(array(
                    'status'  => FALSE,
                    'request' => $i,
                    'reason'  => 'Failed to update deploy configuration, please try again.'
                ));
            }
        } else {
            return 'you are not permitted to do that';
        }
    }

    public function action_start($deploy_id = null) {
        Bootstrapper::first_run($deploy_id);
    }

}
