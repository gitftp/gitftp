<?php

use Symfony\Component\Process\Process;

class Controller_Api_Deploy extends Controller_Api_Apilogincheck {

    public function get_feed($user_id, $deploy_id) {
        $record = new Model_Record();
        $deploy = new Model_Deploy();
        $branch = new Model_Branch();
        $records = $record->get($deploy_id);
        $branches = $branch->get($deploy_id);
        $branchesFormatted = array();
        foreach($branches as $a ){
            $branchesFormatted[$a['id']] = $a;
        }
        try{
            list($deploys) = $deploy->get($deploy_id);
        }catch(Exception $e){
            die('Sorry, something went terribly wrong.');
        }

        $feed = new \Suin\RSSWriter\Feed();
        $channel = new \Suin\RSSWriter\Channel();
        $channel->title("GITFTP : ".$deploys['name'])
            ->description($deploys['repository'])
            ->pubDate(strtotime($deploys['created_at']))
            ->url(dash_url.'#/project/'.$deploy_id)
            ->language('en-US')
            ->appendTo($feed);

        foreach ($records as $k => $v) {
            $item = new \Suin\RSSWriter\Item();
            $item
                ->title("Deployed to ".$branchesFormatted[$v['branch_id']]['name']." +".$v['file_add']." -".$v['file_remove'])
                ->description("Deployed to ".$branchesFormatted[$v['branch_id']]['name']." +".$v['file_add']." -".$v['file_remove'])
                ->url(dash_url.'#/project/'.$deploy_id.'/'.$v['id'])
                ->pubDate($v['date'])
                ->guid($v['id'])
                ->appendTo($channel);
        }

        echo $feed;
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
        $b = $deploy->get(NULL, $a);
        $b = utils::strip_passwords($b);
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
            'data'   => utils::strip_passwords($a)
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

            $deploy = new Model_Deploy();
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
        $i = utils::escapeHtmlChars($i);

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
                $repo_dir = utils::get_repo_dir($deploy_data['id']);
                $git = new \PHPGit\Git();
                $git->setRepository($repo_dir);
                $git->remote->url->set('origin', $newRemote);

                $response = array(
                    'status'  => TRUE,
                    'request' => $i
                );
            } else {
                throw new Exception('Sorry, something went wrong. Please try again later.');
            }

        } catch (Exception $e) {
            $response = array(
                'status'  => FALSE,
                'request' => $i,
                'reason'  => $e->getMessage()
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

                            $hash = utils::git_verify_hash($i['deploy_id'], $i['hash']);
                            if ($hash)
                                $set['hash'] = $hash;
                            else
                                throw new Exception('The hash provided is not valid or does not exist in the repository.');

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
