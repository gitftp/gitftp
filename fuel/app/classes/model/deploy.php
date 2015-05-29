<?php

class Model_Deploy extends Model {

    private $table = 'deploy';
    private $user_id;
    public $id = null;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    public function get($id = null, $select = NULL) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        $q = DB::select_array($select);
        $q = $q->from($this->table)->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();

        foreach ($a as $k => $v) {

            $record = new Model_Record();
            $branch = new Model_Branch();
            $active_records = $record->get($v['id'], FALSE, FALSE, 2);
            $active_count = count($active_records);

            if ($active_count != 0) {

                $total_files = 0;
                $processed_files = 0;

                foreach ($active_records as $ar) {
                    $total_files += $ar['total_files'];
                    $processed_files += $ar['processed_files'];

                }

                $env = $branch->get_by_branch_id($active_records[0]['branch_id']);
                $env = $env[0]['name'];

                $a[$k]['status'] = "deploying to $env. $processed_files/$total_files";

            } else if ($v['cloned'] == 0) {
                $a[$k]['status'] = 'To be initialized';
            } else if ($v['cloned'] == 2) {
                $a[$k]['status'] = 'Processing';
            } else {
                $a[$k]['status'] = 'Idle';
                $a[$k]['status'] = 'Idle';
            }

        }

        return $a;
    }

    public function set($id = null, $set = array(), $direct = FALSE) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        if (!$direct) {

            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id, $direct = FALSE) {
        if (is_null($id) && !is_null($this->id)) {
            $id = $this->id;
        }

        $user_id = $this->user_id;
        $deployrow = DB::select()->from($this->table)->where('id', $id)->and_where('user_id', $user_id)->execute()->as_array();

        if (count($deployrow) == 1) {

            $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deployrow[0]['id'];

            try {
                chdir($repo_dir);
                echo shell_exec('chown www-data * -R');
                echo shell_exec('chgrp www-data * -R');
                echo shell_exec('chmod 777 -R');
                File::delete_dir($repo_dir, TRUE, TRUE);
            } catch (Exception $ex) {
                return FALSE;
            }

            if (count($deployrow) != 0) {
                DB::delete($this->table)->where('id', $id)->execute();

                return TRUE;
            } else {
                return 'No access';
            }
        } else {
            return 'deploy busy';
        }
    }

    public function create($repo_url, $name, $username = null, $password = null, $key, $env) {

        if (!$this->user_id) {
            return FALSE;
        }
        if (!count($env)) {
            return 'Atleast one env required.';
        }

        $deploy_id = DB::insert($this->table)->set(array(
            'repository' => $repo_url,
            'active'     => 0,
            'name'       => $name,
            'user_id'    => $this->user_id,
            'username'   => ($username) ? $username : '',
            'password'   => ($password) ? $password : '',
            'key'        => $key,
            'cloned'     => 0,
            'deployed'   => 0,
            'status'     => '',
            'created_at' => date("Y-m-d H:i:s", (new DateTime())->getTimestamp()),
            'ready'      => 0,
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
            return FALSE;
        }
    }

}
