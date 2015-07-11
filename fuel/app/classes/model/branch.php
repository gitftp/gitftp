<?php

class Model_Branch extends Model {
    // table for branch
    private $table = 'branches';

    // user_id to filter data.
    public $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    /**
     * Get env by ftp id.
     *
     * @param $ftp_id
     * @param bool $direct
     * @return $this
     */
    public function get_by_ftp_id($ftp_id, $direct = FALSE) {
        $q = DB::select()->from($this->table)
            ->where('ftp_id', $ftp_id);
        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }
        $q = $q->execute()->as_array();

        return $q;
    }

    /**
     * get branches of project/deploy.
     * @param type $id ->
     * @param type $select
     * @return type
     */
    public function get($id = NULL, $select = NULL) { // by deploy id
        $q = DB::select_array($select);
        $q = $q->from($this->table)->where('user_id', $this->user_id);

        if ($id != NULL) {
            $q = $q->and_where('deploy_id', $id);
        }

        $a = $q->execute()->as_array();

        foreach($a as $k => $v){
            $a[$k]['skip_path'] = ($a[$k]['skip_path'] !== '0') ? unserialize($a[$k]['skip_path']) : array();
            $a[$k]['purge_path'] = ($a[$k]['purge_path'] !== '0') ? unserialize($a[$k]['purge_path']) : array();
        }

        return $a;
    }

    public function get_by_branch_id($branch_id, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)->where('user_id', $this->user_id)->and_where('id', $branch_id)->execute()->as_array();

        return $q;
    }

    public function get_by_branch_name($branch_name, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)
            ->where('user_id', $this->user_id)
            ->and_where('branch_name', $branch_name)
            ->execute()->as_array();

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
    }

    /**
     * Create a branch,
     *
     * @param $data -> set of data to create.
     * @param null $user_id -> assign to user.
     * @return object
     */
    public function create($data, $user_id = NULL) {
        if (is_null($user_id)) {
            $data['user_id'] = $this->user_id;
        } else {
            $data['user_id'] = $user_id;
        }
        $data['name'] = (!empty($data['name'])) ? $data['name'] : '(unnamed)';
        $data['skip_path'] = (isset($data['skip_path'])) ? $data['skip_path'] : FALSE;
        $data['purge_path'] = (isset($data['purge_path'])) ? $data['purge_path'] : FALSE;

        $a = DB::insert($this->table)->set($data)->execute();

        return $a;
    }
}
