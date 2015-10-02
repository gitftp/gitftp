<?php

class Controller_Api_Etc extends Controller_Api_Apilogincheck {


    public function get_sizeondisk() {

        try {
            $deploy_id = \Input::get('id', NULL);
            if (is_null($deploy_id)) {
                throw new Exception('Missing parameters');
            }

            $deploy = new \Model_Deploy();
            $deploys = $deploy->get($deploy_id);
            if (!count($deploys))
                throw new Exception('Something went wrong, please try again.');

            $path = \Utils::get_repo_dir($deploy_id);
            $op = \Utils::runCommand('du -sb ' . $path, FALSE);
            if(count($op) == 0){
                throw new Exception('Unavailable');
            }
            $count = $op[0];
            $a = preg_split('/\s+/', $count);

            $response = array(
                'status'     => TRUE,
                'size'       => $a[0],
                'size_human' => \Utils::humanize_data($a[0])
            );

        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);
    }

    public function get_totaldeploy() {

        try {
            $deploy_id = \Input::get('id', NULL);
            if (is_null($deploy_id)) {
                throw new Exception('Missing parameters');
            }

            $deploy = new \Model_Deploy();
            $deploys = $deploy->get($deploy_id);
            if (!count($deploys))
                throw new Exception('Something went wrong, please try again.');

            $record = new \Model_Record();
            $data = $record->get_sum_deployed_data($deploy_id);

            $response = array(
                'status'     => TRUE,
                'size'       => $data,
                'size_human' => \Utils::humanize_data($data)
            );
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);

    }

    public function get_unlink() {

        try {
            $user = new \Craftpip\OAuth\Auth();
            $provider = Input::get('provider');
            $provider_data = $user->getProviders($provider);
            if (!$provider_data) {
                throw new \Craftpip\Exception('Sorry something went wrong, please try again later.');
            }
            $user->removeProvider($provider);
            $user->removeAttr($provider);

            $deploy = new \Model_Deploy();
            $deploys = $deploy->get();
            $res = array();
            foreach ($deploys as $a) {
                $repo_provider = \Utils::parseProviderFromRepository($a['repository']);
                if (!empty($a['git_id']) && strtolower($repo_provider) == strtolower($provider)) {
                    $deploy->set($a['id'], array(
                        'active' => FALSE
                    ));
                }
            }

            $response = array(
                'status' => TRUE,
            );
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }

        $this->response($response);
    }

    public function get_unlinkprojects() {
        try {
            $name = \Input::get('provider', NULL);
            if (is_null($name))
                throw new Exception('Something went wrong, please try again.');

            $deploy = new \Model_Deploy();
            $deploys = $deploy->get();
            $res = array();
            foreach ($deploys as $a) {
                $repo_provider = \Utils::parseProviderFromRepository($a['repository']);
                if (!empty($a['git_id']) && strtolower($repo_provider) == strtolower($name)) {
                    $res[] = array(
                        'name'    => $a['name'],
                        'gitname' => $a['git_name']
                    );
                }
            }

            $response = array(
                'status'   => $name,
                'projects' => $res,
            );
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);
    }

    public function get_services() {
        $user = new \Craftpip\OAuth\Auth();
//        $github = ;
        $response = array(
            'github'    => array(
                'username' => $user->getProviders('github', 'username'),
                'added_at' => $user->getProviders('github', 'created_at'),
            ),
            'bitbucket' => array(
                'username' => $user->getProviders('bitbucket', 'username'),
                'added_at' => $user->getProviders('bitbucket', 'created_at')
            )
        );

        $this->response(array(
            'status' => TRUE,
            'data'   => $response
        ));
    }

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
            ->url(dash_url . '/project')
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
                    ->url(dash_url . '/project/' . $v['id'])
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
        $i = Utils::escapeHtmlChars($i);

        $messages->insert(array(
            'message' => $i['message'],
            'type'    => $messages->type_feedback,
            'date'    => time()
        ));

        $this->response(array(
            'status' => TRUE,
        ));
    }

    // todo : we are here.
    public function post_getRemoteBranches() {
        $post = Input::post();
        try {

            if (!isset($post['type'])) {
                if (isset($post['id'])) {
                    $deploy = new \Model_Deploy();
                    $deploys = $deploy->get($post['id']);
                    if (count($deploys)) {
                        if (!empty($deploys[0]['git_id']))
                            $type = 'service';
                    } else {
                        throw new \Craftpip\Exception('Something went wrong');
                    }
                } else {
                    throw new \Craftpip\Exception('Something went wrong');
                }
            } else {
                $type = $post['type'];
            }

            if ($type == 'service') {
                $response = $this->branchesservice();
            } else {
                $response = $this->branchesmanual();
            }

            $response = array(
                'status'  => TRUE,
                'data'    => $response,
                'request' => $post
            );

        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status'  => FALSE,
                'reason'  => $e->getMessage(),
                'request' => $post
            );
        }

        $this->response($response);
    }

    public function branchesservice() {
        $post = Input::post();
        $gitapi = new Craftpip\GitApi();
        $a = $gitapi->loadApi($post['provider'])->getBranches($post['name']);

        return $a;
    }

    public function branchesmanual() {
        $post = Input::post();
        if (isset($post['deploy_id'])) {
            $deploy = new Model_Deploy();
            $data = $deploy->get($post['deploy_id']);

            if (count($data) !== 1)
                throw new \Craftpip\Exception('The project does not exist.');

            $repo = $data[0]['repository'];
            $username = $data[0]['username'];
            $password = $data[0]['password'];
        } else {
            $repo = $post['repo'];
            $username = $post['username'];
            $password = $post['password'];
        }

        $a = Utils::gitGetBranches($repo, $username, $password);
        if ($a) {
            $response = $a;
        } else {
            throw new \Craftpip\Exception('Could not connect to GIT repository.');
        }

        return $response;
    }


    // todo : dashboard.
    public function action_dashboard($what = '') {
        switch ($what) {
            case 'stats':
                $this->dashboard_stats();

                return FALSE;
                break;
        }
        $user = new \Craftpip\OAuth\Auth();
        list(, $user_id) = $user->get_user_id();
        $deploy = new \Model_Deploy();
        $deploy_data = $deploy->get();
        $ftp = new \Model_Ftp();
        $ftp_data = $ftp->get();

        $this->response(array(
            'status' => TRUE,
            'data'   => array(
                'user'    => array(
                    'id'     => (string)$user_id,
                    'name'   => $user->get_screen_name(),
                    'email'  => $user->get_email(),
                    'avatar' => \Utils::get_gravatar($user->get_email(), 40)
                ),
                'account' => array(
                    'projects' => count($deploy_data),
                    'ftp'      => count($ftp_data)
                )
            ),
        ));
    }

    public function dashboard_stats() {
        $deploy = new Model_Deploy();
        $user = new \Craftpip\OAuth\Auth();
        $records = new Model_Record();
        $records_count = $records->get_count(NULL, FALSE, $records->success);
        $deployed_data = $records->get_sum_deployed_data(NULL, FALSE);
        $deployed_data = Utils::humanize_data($deployed_data);
        $deploy_data = $deploy->get(NULL, array('id', 'cloned'));
        $project_limit = ($user->getAttr('project_limit')) ? $user->getAttr('project_limit') : '&infin;';

        $this->response(array(
            'status' => TRUE,
            'data'   => array(
                'projects'       => count($deploy_data),
                'projects_limit' => $project_limit,
                'deploy_count'   => $records_count,
                'deployed_data'  => $deployed_data
            )
        ));
    }

    public function dashboard_init() {

    }
}