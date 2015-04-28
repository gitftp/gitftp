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

    public function get($id = null, $select = array()) {

        if (count($select) == 0) {
            $q = DB::select();
        } else {
            $q = DB::select_array($select);
        }

        $q = $q->from($this->table)
                ->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();

        foreach ($a as $k => $v) {

            if (isset($v['ftp'])) {
                $a[$k]['ftp'] = unserialize($v['ftp']);
            }
//            $a[$k]['lastdeploy'] = Date::forge($a[$k]['lastdeploy'])->format("%m/%d/%Y %H:%M");
        }
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

        $status = strtolower($b[0]['status']);

        if ($status == 'idle' || $status == 'to be initialized') {

            $user_dir = DOCROOT . 'fuel/repository/' . $user_id;
            $repo_dir = DOCROOT . 'fuel/repository/' . $user_id . '/' . $deployrow[0]['id'];

            try {
                chdir($repo_dir);
                echo shell_exec('chown www-data * -R');
                echo shell_exec('chgrp www-data * -R');
                echo shell_exec('chmod 777 -R');
                File::delete_dir($repo_dir, true, true);
            } catch (Exception $ex) {
                
            }

            if (count($b) != 0) {
                DB::delete('deploy')->where('id', $id)->execute();
                echo json_encode(array(
                    'status' => true,
                    'request' => $id,
                ));
            } else {
                echo json_encode(array(
                    'status' => false,
                    'request' => $id,
                    'reason' => 'No access'
                ));
            }
        } else {
            return json_encode(array(
                'status' => false,
                'reason' => 'deploy busy, unable to delete in between of work',
                'request' => $id
            ));
        }


        $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();
        if (empty($a) or $a[0]['user_id'] != $this->user_id) {
            return false;
        }
        return DB::delete($his->table)->where('id', $id)->execute();
    }

    public function create($data) {
        
    }

}
