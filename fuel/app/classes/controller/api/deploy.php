<?php

use Symfony\Component\Process\Process;

class Controller_Api_Deploy extends Controller_Api_Apilogincheck {

    public function get_limit() {
        $user = new \Craftpip\Auth();
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

        try {
            if ($is_active) {
                throw new Exception('Deployment is in progress, please try again later.');
            }
            $deploy = new Model_Deploy();
            $answer = $deploy->delete($id);
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
        }

        $this->response($response);
    }

    public function post_create() {
        try {
            $i = Input::post();
            // todo: verify all details.


            $user = new \Craftpip\Auth();
            $limit = $user->getAttr('project_limit');
            $deploy = new Model_Deploy();
            $deploy_data = $deploy->get(NULL, array(
                'id', 'cloned'
            ));
            if (count($deploy_data) >= $limit) {
                throw new Exception('Sorry, project limit has reached.');
            }

            $deploy_id = $deploy->create($i['repo'], $i['name'], $i['username'], $i['password'], $i['key'], $i['env'], 1);

            if ($deploy_id) {
                $response = array(
                    'status'  => TRUE,
                    'request' => $i
                );
            } else {
                throw new Exception('Sorry, we got confused.');
            }
        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $e->getMessage(),
            );
        }

        $this->response($response);
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
            $repo_dir = Utils::get_repo_dir($deploy_id);
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
                            if(empty($f)){
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

            Gfcore::deploy_in_bg($deploy_id);
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
