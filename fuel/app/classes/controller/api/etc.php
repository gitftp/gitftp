<?php

class Controller_Api_Etc extends Controller_Api_Apilogincheck {

    public function get_feed() {
        list(, $user_id) = \Auth::instance()->get_user_id();

        $record = new Model_Record();
        $deploy = new Model_Deploy();
        $branch = new Model_Branch();
        $deploy_data = $deploy->get();

        $feed = new \Suin\RSSWriter\Feed();
        $channel = new \Suin\RSSWriter\Channel();
        $channel->title("GITFTP: Project deployment feed.")
            ->description("")
            ->url(dash_url . '#/project')
            ->language('en-US')
            ->appendTo($feed);


        foreach ($deploy_data as $v) {

            $record_data = $record->get($v['id'], FALSE, FALSE, $record->success);
            $branch_data = $branch->get($v['id']);
            $branch_Formated = array();
            foreach ($branch_data as $a) {
                $branch_Formated[$a['id']] = $a;
            }

            foreach ($record_data as $k => $v2) {
                $item = new \Suin\RSSWriter\Item();
                $item
                    ->title("Deployed " . $v['name'] . ' - ' . $branch_Formated[$v2['branch_id']]['name'] . " +" . $v2['file_add'] . " -" . $v2['file_remove'])
                    ->description("Successfully deployed " . $v['name'] . ' - ' . $branch_Formated[$v2['branch_id']]['name'] . ". Files changed: +" . $v2['file_add'] . " -" . $v2['file_remove'])
                    ->url(dash_url . '#/project/' . $v['id'])
                    ->pubDate($v2['date'])
                    ->guid($v2['id'])
                    ->appendTo($channel);
            }

        }


        echo $feed;
    }

    public function post_feedback() {
        $i = Input::post();

        $messages = new Model_Messages();
        $i = utils::escapeHtmlChars($i);

        $messages->insert(array(
            'message' => $i['message'],
            'type'    => 1,
            'date'    => time()
        ));

        $this->response(array(
            'status' => TRUE,
        ));
    }

    public function post_getRemoteBranches() {
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
                $response = array(
                    'status'  => TRUE,
                    'data'    => $a,
                    'request' => $post
                );
            } else {
                throw new Exception('Could not connect to GIT repository.');
            }
        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $post
            );
        }

        $this->response($response);
    }

    // todo : dashboard.
    public function action_dashboard() {
        $deploy = new Model_Deploy();
        $user_id = Auth::get_user_id()[1];

        $dir = DOCROOT . 'fuel/repository/' . $user_id;
        $a = shell_exec("du -hs $dir");
        $a = explode('	', $a);
        $disk_usage_human = $a[0];
        $deploy_list = $deploy->get(NULL, array(
            'repository',
            'id',
            'name',
            'cloned',
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
}