<?php

use Symfony\Component\Process\Process;

class Controller_Api_Deploy extends Controller_Api_Apilogincheck {

    public function get_limit() {
        $user = new \Craftpip\OAuth\Auth();
        $limit = $user->getAttr('project_limit');
        $deploy = new Model_Deploy();
        $deploy_data = $deploy->get(NULL, array('id', 'cloned'));

        $this->response(array(
            'status' => TRUE,
            'data'   => array(
                'projects' => count($deploy_data),
                'limit'    => (int)$limit,
            )
        ));
    }

    /**
     * Get selected only deploy data.
     *
     * @param null $id
     */
    public function get_only($id = NULL) {
        $a = Input::get();
        $deploy = new Model_Deploy();
        $a = explode(',', $a['select']);
        array_push($a, 'cloned'); // neeeded for getting status.
        $b = $deploy->get($id, $a);
        $b = Utils::strip_passwords($b);
        $response = array(
            'status' => TRUE,
            'data'   => $b
        );
        $this->response($response);
    }

    public function get_get($id = NULL) {
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

        $response = array(
            'status' => TRUE,
            'data'   => Utils::strip_passwords($a)
        );

        $this->response($response, 200);
    }

    public function delete_delete($id = NULL) { // deploy id.

        $record = new Model_Record();
        $is_active = $record->is_queue_active($id);
        $force = Input::delete('force', 0); // force delete even if the deploy is in process.
        try {
            if ($is_active && $force == 0)
                throw new Exception('Deployment is in progress, please try again later.', 19293);

            $deploy = new Model_Deploy();
            $deploy_data = $deploy->get($id);
            if (count($deploy_data) !== 1)
                throw new \Craftpip\Exception('Something went wrong, please try again later.');

            $deploy_data = $deploy_data[0];
            $hook_id = $deploy_data['git_hook_id'];
            if ($hook_id) {
                $gitapi = new \Craftpip\GitApi();
                $provider = \Utils::parseProviderFromRepository($deploy_data['repository']);
                try {
                    $gitapi->loadApi($provider)->removeHook($deploy_data['git_name'], $hook_id);
                } catch (Exception $e) {
                    // if it fails? Its because maybe the user has re authenticated himself from another account.
                }
            }

            $answer = $deploy->delete($id);
            $path = \Utils::get_repo_dir($id);

            if (file_exists($path)) {
                $process = new \Symfony\Component\Process\Process('rm -rf ' . $path);
                $process->run();
                if (!$process->isSuccessful()) {
                    // failed? apparantly the folder was not readable ?
                }
            }

            if ($answer) {
                $response = array(
                    'status'  => TRUE,
                    'request' => $id,
                );
            } else {
                throw new Exception('We got confused, please try again later.');
            }
        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'request' => $id,
                'reason'  => $e->getMessage(),
            );
            if ($e->getCode() == 19293) {
                $response['active'] = TRUE;
            }
        }

        $this->response($response);
    }

    public function post_create() {
        try {
            $i = Input::post();
            // todo: verify all details.
            $user = new \Craftpip\OAuth\Auth();
            $limit = $user->getAttr('project_limit');
            $deploy = new Model_Deploy();
            $branch = new Model_Branch();
            $deploy_data = $deploy->get(NULL, array(
                'id', 'cloned'
            ));

            if (count($deploy_data) >= $limit) {
                throw new \Craftpip\Exception('Sorry, project limit has reached.');
            }

            $gitapi = new \Craftpip\GitApi();

            if ($i['type'] == 'service') {
                $type = 'service';
                $repo = $i['repo'];
                $username = '';
                $password = '';
                $name = $i['name'];
                $key = $i['key'];
                $env = $i['env'];
                $gitname = $i['gitname'];
                $gitid = $i['gitid'];
                $active = 1;
                $branches = $gitapi->loadApi($i['provider'])->getBranches($i['gitname']);
            } else {
                $type = 'manual';
                $repo = $i['repo'];
                $name = $i['name'];
                $username = $i['username'];
                $password = $i['password'];
                $key = $i['key'];
                $env = $i['env'];
                $gitname = '';
                $gitid = '';
                $active = 1;
                $branches = \Utils::gitGetBranches($repo, $username, $password);
            }

            if (empty($key) || !$key || is_null($key))
                $key = \Str::random('hexdec', 10);

            if (!$branches) {
                throw new \Craftpip\Exception('Could not connect to repository.');
            }

            $deploy_id = $deploy->create($gitid, $gitname, $type, $repo, $name, $username, $password, $key, $env, $active, $branches);

            if ($deploy_id && $i['type'] == 'service') {
                // set the web hook.
                try {
                    $url = $gitapi->buildHookUrl($deploy_id, $key);
                    $a = $gitapi->loadApi($i['provider'])->setHook($gitname, $url);
                    $deploy->set($deploy_id, array(
                        'git_hook_id' => $a['id']
                    ));
                } catch (Exception $e) {
                    // If there is an error is setting the hook, delete the created deploy, and show an error.
                    $deploy->delete($deploy_id);
                    throw new \Craftpip\Exception('The project could not be created, please try again.');
                }
            }

            $record = new \Model_Record();
            $set = array(
                'deploy_id'   => $deploy_id,
                'branch_id'   => NULL,
                'date'        => time(),
                'triggerby'   => '',
                'status'      => $record->in_queue,
                'record_type' => $record->type_first_clone,
            );
            $record->insert($set);

            foreach ($env as $ev) {
                if ($ev['env_deploy_now']) {
                    $branch = $branch->get_by_ftp_id($ev['env_ftp']);
                    $branch = $branch[0];
                    $set = array(
                        'deploy_id'   => $branch['deploy_id'],
                        'branch_id'   => $branch['id'],
                        'date'        => time(),
                        'triggerby'   => '',
                        'status'      => $record->in_queue,
                        'record_type' => $record->type_sync,
                    );
                    $record->insert($set);
                }
            }
            \Utils::startDeploy($deploy_id);

            if ($deploy_id) {
                $response = array(
                    'status'  => TRUE,
                    'request' => $i
                );
            } else {
                throw new \Craftpip\Exception('Sorry, the request could not be processed. Please try again later.');
            }

        } catch (Exception $e) {
            throw $e;
            $e = new \Craftpip\Exception($e->getMessage(), $e->getCode());
            $response = array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $e->getMessage(),
            );
        }

        $this->response($response);
    }

    public function get_startdeploy() {
        \Utils::startDeploy(19);
    }

    public function post_update($id) {

        $i = Input::post();
        $i = Utils::escapeHtmlChars($i);

        $deploy = new Model_Deploy();
        $deploy_data = $deploy->get($id);

        try {
            if (count($deploy_data)) {
                $deploy_data = $deploy_data[0];
            } else {
                throw new Exception('Sorry, we got confused. No project was found.');
            }

            // data to update
            $data = array(
                'name' => $i['name'],
                'key'  => $i['key'],
            );

            if (isset($i['isprivate'])) {
                if (isset($i['username']))
                    $data['username'] = $i['username'];
                if (isset($i['password']))
                    $data['password'] = $i['password'];
            } else {
                $data['username'] = '';
                $data['password'] = '';
            }

            $result = $deploy->set($id, $data);

            try {
                if ($result[1] !== 0) {
                    // changing clone url in git.
                    list($deploy_data) = $deploy->get($id);
                    $repo_url = parse_url($deploy_data['repository']);

                    if (!empty($deploy_data['username'])) {
                        $repo_url['user'] = $deploy_data['username'];
                        if (!empty($deploy_data['password'])) {
                            $repo_url['pass'] = $deploy_data['password'];
                        }
                    }

                    $newRemote = http_build_url($repo_url);
                    $repo_dir = Utils::get_repo_dir($deploy_data['id']);
                    $git = new \PHPGit\Git();
                    $git->setRepository($repo_dir);
                    $git->remote->url->set('origin', $newRemote);

                } else {
                    throw new Exception('Sorry, something went wrong. Please try again later.');
                }
            } catch (Exception $e) {

            }
            $response = array(
                'status'  => TRUE,
                'request' => $i
            );
        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $e->getMessage() . $e->getLine() . $e->getFile()
            );
        }

        $this->response($response);
    }

    /*
     * Run the deploy for a given branch.
     */
    public function post_run() {
        $i = Input::post();

        try {
            if (!isset($i['deploy_id']) || !isset($i['type']))
                throw new Exception('Missing parameter.');


            $record = new Model_Record();
            $branch = new Model_Branch();
            $deploy = new Model_Deploy();
            $deploy_id = $i['deploy_id'];
            $repo_dir = \Utils::get_repo_dir($deploy_id);
            $git = new \Craftpip\Git();
            $git->setRepository($repo_dir);

            if (isset($i['branch_id'])) {
                $branches = $branch->get_by_branch_id($i['branch_id'], array(
                    'id',
                    'auto',
                    'deploy_id',
                    'branch_name'
                ));
            } else {
                $branches = $branch->get($deploy_id, array(
                    'id',
                    'auto',
                    'deploy_id',
                    'branch_name'
                ));
            }

            // type can be
            // sync, update, revert.

            if (count($branches) > 0) {
                foreach ($branches as $singlebranch) {

                    $set = array(
                        'deploy_id' => $deploy_id,
                        'branch_id' => $singlebranch['id'],
                        'date'      => time(),
                        'triggerby' => '',
                        'status'    => $record->in_queue,
                    );

                    switch ($i['type']) {
                        case 'update':
                            $set['record_type'] = $record->type_update;
                            break;

                        case 'sync':
                            $set['record_type'] = $record->type_sync;
                            break;

                        case 'revert':
                            $set['record_type'] = $record->type_rollback;
                            if (!isset($i['hash']))
                                throw new Exception('Missing parameter hash.');
                            else
                                $i['hash'] = trim($i['hash']);

                            $branches = $git->branch();
                            if (array_key_exists($i['hash'], $branches))
                                throw new Exception('The hash provided is a Branch. Please enter a valid hash');

                            $tags = $git->tag();
                            if (\Arr::in_array_recursive($i['hash'], $tags))
                                throw new Exception('The hash provided is a Tag. Please enter a valid hash');

                            try {
                                $hash = $git->verifyhash($i['hash']);
                                $set['hash'] = $hash;
                            } catch (Exception $e) {
                                throw new Exception('The hash provided is not valid or does not exist in the repository.');
                            }

                            $process = $git->getProcessBuilder()->add('branch')
                                ->add('-a')
                                ->add('--contains')
                                ->add($i['hash'])->getProcess();
                            $a = $git->run($process);

                            $f = strpos($a, $singlebranch['branch_name']);
                            if (empty($f)) {
                                throw new Exception('The hash does not belong to the current environment branch.');
                            }
                            break;

                        default:
                            throw new Exception('Invalid value Type passed.');
                            break;
                    }


                    $record_id = $record->insert($set);
                }
            }

            \Gfcore::deploy_in_bg($deploy_id);
            $response = array(
                'status' => TRUE,
            );

        } catch (Exception $e) {
            $response = array(
                'status' => FALSE,
                'reason' => $e->getMessage(),
            );
        }

        $this->response($response);
    }

}
