<?php

class Model_Branch extends Model {
    private $table = 'branches';
    public $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    public function get_by_deploy_id($deploy_id, $direct = FALSE) {
        $q = DB::select()->from($this->table)
            ->where('deploy_id', $deploy_id);
        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }
        $q = $q->execute()->as_array();

        $q = $this->unserializeData($q);

        return $q;
    }

    public function get_by_ftp_id($ftp_id, $direct = FALSE) {
        $q = DB::select()->from($this->table)
            ->where('ftp_id', $ftp_id);
        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }
        $q = $q->execute()->as_array();

        $q = $this->unserializeData($q);

        return $q;
    }

    public function get($id = NULL, $select = NULL) { // by deploy id
        $q = DB::select_array($select);
        $q = $q->from($this->table)->where('user_id', $this->user_id);

        if ($id != NULL) {
            $q = $q->and_where('deploy_id', $id);
        }

        $a = $q->execute()->as_array();
        $a = $this->unserializeData($a);

        return $a;
    }

    private function unserializeData($a) {
        foreach ($a as $k => $v) {
            if (isset($a[$k]['purge_path']))
                $a[$k]['purge_path'] = ($a[$k]['purge_path'] !== '0') ? unserialize($a[$k]['purge_path']) : array();
            if (isset($a[$k]['skip_path']))
                $a[$k]['skip_path'] = ($a[$k]['skip_path'] !== '0') ? unserialize($a[$k]['skip_path']) : array();
        }

        return $a;
    }

    public function get_by_branch_id($branch_id, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)->where('user_id', $this->user_id)->and_where('id', $branch_id)->execute()->as_array();
        $q = $this->unserializeData($q);

        return $q;
    }

    public function get_by_branch_name($branch_name, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)
            ->where('user_id', $this->user_id)
            ->and_where('branch_name', $branch_name)
            ->execute()->as_array();

        $q = $this->unserializeData($q);

        return $q;
    }

    public function get_by_branch_name_deploy_id($branch_name, $deploy_id, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)
            ->where('user_id', $this->user_id)
            ->and_where('branch_name', $branch_name)
            ->and_where('deploy_id', $deploy_id)
            ->execute()->as_array();

        $q = $this->unserializeData($q);

        return $q;
    }

    public function set($id, $set = array(), $direct = FALSE) {

        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        if (isset($set['skip_path']))
            $set['skip_path'] = serialize($set['skip_path']);

        if (isset($set['purge_path']))
            $set['purge_path'] = serialize($set['purge_path']);


        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($branch_id, $direct = FALSE) {
        $q = DB::select()
            ->from($this->table)
            ->where('id', $branch_id);

        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }

        $q = $q->execute()->as_array();

        if (count($q) !== 1) {
            return FALSE;
        }

        $a = DB::delete($this->table)->where('id', $branch_id)->execute();

        return $a;
    }

    public function create($data, $user_id = NULL) {
        if (is_null($user_id)) {
            $data['user_id'] = $this->user_id;
        } else {
            $data['user_id'] = $user_id;
        }

        $data['name'] = (!empty($data['name'])) ? $data['name'] : '(unnamed)';

        if (isset($data['skip_path'])) {
            $data['skip_path'] = serialize($data['skip_path']);
        }
        if (isset($data['purge_path'])) {
            $data['purge_path'] = serialize($data['purge_path']);
        }

        $a = DB::insert($this->table)->set($data)->execute();

        return $a;
    }
}

