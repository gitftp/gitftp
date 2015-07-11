<?php

class Model_Deploy extends Model {

    private $table = 'deploy';
    public $user_id;
    public $id = NULL; // deploy id.

    public function __construct() {
        if (Auth::check()) {
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
        }

        return $a;
    }

    /**
     * Get status of deploy by ID.
     * (optional) $data can be passed to filter the data from.
     *
     * @param $id
     * @param null $data
     * @return string
     */
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
            $env = $env[0]['name'];

            $processed_files = ($processed_files !== 0) ? $processed_files : '&hellip;';
            $total_files = ($total_files !== 0) ? $total_files : '&hellip;';

            $status = "Deploying to $env | $processed_files of $total_files files";

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

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id, $direct = FALSE) {
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

        return DB::delete($this->table)->where('id', $id)->execute();
    }

    public function create($repo_url, $name, $username = NULL, $password = NULL, $key, $env) {

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
            return FALSE;
        }
    }

}
