<?php

class Model_Deploy extends Model {

    private $table = 'deploy';
    private $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            return false;
        }
    }

    public function get($id = null, $select = NULL) {

        $q = DB::select_array($select);

        $q = $q->from($this->table)
                ->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();

        return $a;
    }

    public function set($id, $set = array(), $direct = false) {

        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return false;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id) {

        $user_id = $this->user_id;
        $deployrow = DB::select()->from($this->table)->where('id', $id)->and_where('user_id', $user_id)
                        ->execute()->as_array();

        $status = strtolower($deployrow[0]['status']);

        if ($status == 'idle' || $status == 'to be initialized') {

            $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deployrow[0]['id'];

            try {
                chdir($repo_dir);
                echo shell_exec('chown www-data * -R');
                echo shell_exec('chgrp www-data * -R');
                echo shell_exec('chmod 777 -R');
                File::delete_dir($repo_dir, true, true);
            } catch (Exception $ex) {
                return false;
            }

            if (count($deployrow) != 0) {

                DB::delete($this->table)->where('id', $id)->execute();
                return true;
            } else {
                return 'No access';
            }
        } else {
            return 'deploy busy';
        }
    }

    public function create($repo_url, $name, $username = null, $password = null, $key, $env) {

        if (!$this->user_id) {
            return false;
        }
        if (!count($env)) {
            return 'Atleast one env required.';
        }

        $deploy_id = DB::insert($this->table)->set(array(
                    'repository' => $repo_url,
                    'active' => 0,
                    'name' => $name,
                    'user_id' => $this->user_id,
                    'username' => ($username) ? $username : '',
                    'password' => ($password) ? $password : '',
                    'key' => $key,
                    'cloned' => 0,
                    'deployed' => 0,
                    'lastdeploy' => 0,
                    'status' => 'to be initialized',
                    'created_at' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
                    'ready' => 0,
                ))->execute();

        foreach ($env as $k => $v) {
            $env = DB::insert('branches')->set(array(
                        'repo_id' => $deploy_id[0],
                        'user_id' => $this->user_id,
                        'name' => $v['env_name'],
                        'branch_name' => $v['env_branch'],
                        'auto' => ($v['env_deploy'] == 'true') ? 1 : 0,
                        'ftp_id' => $v['env_ftp'],
                        'ready' => 0,
                        'skip_path' => false,
                        'purge_path' => false,
                        'revision' => '',
                    ))->execute();
        }

        if ($deploy_id[1] !== 0) {
            return $deploy_id[0];
        } else {
            return false;
        }
    }

}
