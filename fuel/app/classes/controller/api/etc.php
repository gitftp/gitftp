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
            if (count($op) == 0) {
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

    public function get_webhook() {
        try {
            $deploy = new \Model_Deploy();
            $auth = new \Craftpip\OAuth\Auth();
            $projects = $deploy->get(NULL, array('id', 'name', 'key', 'git_name', 'git_hook_id', 'cloned', 'repository'));
            $projects2 = array();
            foreach ($projects as $a => $b) {
                if (!empty($b['git_hook_id'])) {
                    $b['git_username'] = $auth->getProviders($b['provider'], 'username');
                    $projects2[] = $b;
                }
            }
            $response = array(
                'status' => TRUE,
                'data'   => $projects2,
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

    public function post_webhook() {
        try {
            $i = $_POST;
            if (!isset($i['id']) || !isset($i['key']))
                throw new \Craftpip\Exception('Something went wrong, please try again later.');


            $deploy_id = $i['id'];
            $key = $i['key'];

            $deploy = new \Model_Deploy();
            $project = $deploy->get($deploy_id);
            if (!count($project)) {
                throw new \Craftpip\Exception('Something is not right, please try again later.');
            }

            $project = $project[0];
            $hook_id = $project['git_hook_id'];
            $git_name = $project['git_name'];

            $provider = \Utils::parseProviderFromRepository($project['repository']);
            $gitapi = new \Craftpip\GitApi();
            $gitapi->loadApi($provider);
            $url = $gitapi->buildHookUrl($deploy_id, $key);
            $apiResponse = $gitapi->api->updateHook($git_name, $hook_id, $url);

            if ($apiResponse['url'] == $url) {
                // successfull.
                $deploy->set($deploy_id, array(
                    'key' => $key
                ));
            }

            $response = array(
                'status' => TRUE,
                'res'    => $apiResponse
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

//        echo '<pre>';
//        print_r($i);
//        die;

        $messages->insert(array(
            'message' => $i['message'],
            'type'    => $messages->type_feedback,
            'date'    => time()
        ));

        $this->response(array(
            'status' => TRUE,
        ));
    }

    public $type;
    public $id = NULL;
    public $provider;
    public $name;


    public function post_getremotebranches() {
        $i = Input::post();

        try {
            $id = isset($i['id']) ? $i['id'] : NULL; // deploy id.
            $type = isset($i['type']) ? $i['type'] : 'manual';
            $provider = isset($i['provider']) ? $i['provider'] : NULL;
            $name = isset($i['name']) ? $i['name'] : NULL;

            $deploy = new Model_Deploy();

            if (!is_null($id)) {
                $deploy_data = $deploy->get($id);
                if (count($deploy_data) == 0)
                    throw new Exception('Something is not right, please try again later.');

                $deploy_data = $deploy_data[0];

                if (!empty($deploy_data['git_name'])) {
                    $type = 'service';
                    $provider = \Utils::parseProviderFromRepository($deploy_data['repository']);
                    $name = $deploy_data['git_name'];
                }
            }

            if ($type == 'service') {
                $gitapi = new Craftpip\GitApi();
                $a = $gitapi->loadApi($provider)->getBranches($name);
                $response = array(
                    'status' => TRUE,
                    'data'   => $a,
                );
            } else {
                if (is_null($id)) {
                    $repo = $i['repo'];
                    $username = $i['username'];
                    $password = $i['password'];
                } else {
                    $data = $deploy->get($id);
                    if (!count($data))
                        throw new \Craftpip\Exception('Something went wrong, please try again later.');

                    $repo = $data[0]['repository'];
                    $username = $data[0]['username'];
                    $password = $data[0]['password'];
                }

                $a = \Utils::gitGetBranches($repo, $username, $password);
                if ($a) {
                    $response = array(
                        'status' => TRUE,
                        'data'   => $a,
                    );
                } else {
                    throw new \Craftpip\Exception('Could not connect to GIT repository.');
                }
            }
        } catch (Exception $e) {
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }
        $this->response($response);
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

    public function get_me() {
        $auth = new \Craftpip\OAuth\Auth();
        try {
            $deploy = new \Model_Deploy();
            $projects = $deploy->get(NULL, array('id', 'cloned', 'name'));
            $response = array(
                'status' => FALSE,
                'data'   => array(
                    'username'      => $auth->get_screen_name(),
                    'email'         => $auth->get_email(),
                    'id'            => $auth->user_id,
                    'verified'      => $auth->getAttr('verified'),
                    'project_limit' => $auth->getAttr('project_limit'),
                    'projects'      => $projects,
                )
            );
        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage()
            );
        }
        $this->response($response);

    }
}