<?php

class Model_Deploy extends Model {
    private $table = 'deploy';
    public $user_id;
    public $id = NULL; // deploy id.

    public $clone_success = 1;
    public $clone_failed = 0;
    public $clone_working = 2;

    public function __construct($user_id = null) {
        if(!is_null($user_id)){
            $this->user_id = $user_id;
        }elseif (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    public function get($id = NULL, $select = NULL, $direct = FALSE) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        $q = DB::select_array($select)->from($this->table);

        if (!$direct) {
            $q = $q->where('user_id', $this->user_id);
        }

        if ($id != NULL) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();
        foreach ($a as $k => $v) {
            $id = $v['id'];
            $a[$k]['status'] = $this->getStatus($id, $v);
            if (isset($v['repository']))
                $a[$k]['provider'] = \Utils::parseProviderFromRepository($v['repository']);

            if (isset($v['password']))
                $a[$k]['password'] = \Crypt::instance()->decode($a[$k]['password']);
        }

        return $a;
    }

    // todo: compatible to new record type. init Something ...
    public function getStatus($id, $data = NULL) {
        $status = '';

        if (is_null($data)) {
            $data = $this->get($id);
            $data = $data[0];
        }

        $record = new Model_Record();
        $branch = new Model_Branch();
        $active_records = $record->get($id, FALSE, FALSE, $record->in_progress);
        $queued_records = $record->get($id, FALSE, FALSE, $record->in_queue);
        $active_count = count($active_records);
        $queue_count = count($queued_records);

        if ($active_count != 0) {
            $total_files = 0;
            $processed_files = 0;

            foreach ($active_records as $ar) {
                $total_files += $ar['total_files'];
                $processed_files += $ar['processed_files'];
            }

            $env = $branch->get_by_branch_id($active_records[0]['branch_id']);

            $processed_files = ($processed_files !== 0) ? $processed_files : '&hellip;';
            $total_files = ($total_files !== 0) ? $total_files : '&hellip;';

            if(!empty($env)){
                $env = $env[0]['name'];
                if(strlen($env) > 12)
                    $env = substr($env, 0, 12).'..';
                $status = "Deploying to $env | $processed_files of $total_files files";
            }else{
                $status = "Preparing project...";
            }
        } else if ($data['cloned'] == 0) {
            $status = 'To be initialized';
        } else if ($data['cloned'] == 2) {
            $status = 'Processing';
        } else {
            $status = 'Idle';
        }

        return $status;
    }

    public function set($id = NULL, $set = array(), $direct = FALSE) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();
            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        if (isset($set['password']))
            $set['password'] = \Crypt::instance()->encode($set['password']);


        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id = NULL, $direct = FALSE) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        $user_id = $this->user_id;
        $deployrow = DB::select()->from($this->table)->where('id', $id)->and_where('user_id', $user_id)->execute()->as_array();

        if (count($deployrow) != 1) {
            throw new Exception('Project not found.');
        }

        $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deployrow[0]['id'];
        try {
            chdir($repo_dir);
            echo shell_exec('chown www-data * -R');
            echo shell_exec('chgrp www-data * -R');
            echo shell_exec('chmod 777 -R *');

            try {
                File::read_dir($repo_dir);
                try {
                    File::delete_dir($repo_dir, TRUE, TRUE);
                } catch (Exception $e) {
                    throw new Exception('Could not delete project. Please contact support.');
                }
            } catch (Exception $e) {
                // folder could not be read (is not present), CONTINUE.
            }
        } catch (Exception $ex) {
            // folder doesnt exist.!!
        }

        return \DB::delete($this->table)->where('id', $id)->execute();
    }

    public function create($gitid, $gitname, $type, $repo_url, $name, $username = NULL, $password = NULL, $key = NULL, $env, $active = 0, $branches) {
        if (!$this->user_id) {
            throw new \Craftpip\Exception('No logged in user found.');
        }

        if (!count($env)) {
            throw new \Craftpip\Exception('Atleast one environement is required.');
        }

        $fields = array(
            'repo'     => $repo_url,
            'name'     => $name,
            'username' => $username,
            'password' => $password,
            'key'      => $key,
            'env'      => $env,
        );

        $v = \Validation::forge();
        $v->add_field('repo', '', 'required|valid_url');
        $v->add_field('name', '', 'required');
        $v->add_field('key', '', 'required');
        $selectedFtps = [];

        foreach ($env as $k => $e) {
            $v->add_field('env[' . $k . '][env_name]', '', 'required');
            $v->add_field('env[' . $k . '][env_branch]', '', 'required');
            if (!\Arr::in_array_recursive($e['env_branch'], $branches)) {
                throw new \Craftpip\Exception('Sorry, we got confused.');
            }
            $selectedFtps[] = $e['env_ftp'];
            $v->add_field('env[' . $k . '][env_ftp]', '', 'required');
            $v->add_field('env[' . $k . '][env_deploy]', '', 'required');
        }

        // todo: validation for ftp already in use.

        if (count($selectedFtps) !== count(array_unique($selectedFtps)))
            throw new \Craftpip\Exception('Sorry, we got confused.');

        if (!$v->run($fields))
            throw new \Craftpip\Exception('Sorry, we got confused.');

        if ($this->user_id == '*')
            throw new \Craftpip\Exception('Sorry, we got confused, please refresh your page and try again.');

        $deploy_id = DB::insert($this->table)->set(array(
            'repository' => $repo_url,
            'active'     => $active,
            'name'       => $name,
            'user_id'    => $this->user_id,
            'username'   => ($username) ? $username : '',
            'password'   => ($password) ? \Crypt::instance()->encode($password) : '',
            'key'        => $key,
            'cloned'     => 0,
            'git_name'   => $gitname,
            'git_id'     => $gitid,
            'created_at' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
        ))->execute();

        foreach ($env as $k => $v) {
            $env = DB::insert('branches')->set(array(
                'deploy_id'   => $deploy_id[0],
                'user_id'     => $this->user_id,
                'name'        => $v['env_name'],
                'branch_name' => $v['env_branch'],
                'auto'        => ($v['env_deploy'] == 'true') ? 1 : 0,
                'ftp_id'      => $v['env_ftp'],
                'ready'       => 0,
                'skip_path'   => FALSE,
                'purge_path'  => FALSE,
                'revision'    => '',
            ))->execute();
        }

        if ($deploy_id[1] !== 0) {
            return $deploy_id[0];
        } else {
            throw new \Craftpip\Exception('Sorry, we got confused, please refresh your page and try again.');
        }
    }
}
