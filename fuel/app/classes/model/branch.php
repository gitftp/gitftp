<?php

class Model_Branch extends Model {

    private $table = 'branches';
    private $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    /**
     * get branches of project/deploy.
     * @param type $id ->
     * @param type $select
     * @return type
     */
    public function get($id = null, $select = NULL) { // by deploy id
        $q = DB::select_array($select);
        $q = $q->from($this->table)->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('deploy_id', $id);
        }

        $a = $q->execute()->as_array();

        return $a;
    }

    public function get_by_branch_id($branch_id, $select = NULL) {
        $q = DB::select_array($select)->from($this->table)->where('user_id', $this->user_id)->and_where('id', $branch_id)->execute()->as_array();

        return $q;
    }

    public function set($id, $set = array(), $direct = FALSE) {

        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id, $direct = FALSE) {
        if (!$direct) {
            $user_id = $this->user_id;
            $deployrow = DB::select()->from($this->table)->where('deploy_id', $id)->and_where('user_id', $user_id)->execute()->as_array();
        }
    }

}
