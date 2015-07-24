<?php

class Model_Messages extends Model {

    private $table = 'messages';
    public $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    public function get($id = NULL) {

        $q = DB::select()->from($this->table)
            ->where('user_id', $this->user_id);

        if ($id != NULL) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();

        return $a;
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
        return DB::delete($this->table)->where('id', $id)->execute();
    }

    public function insert($ar) {
        $ar['user_id'] = $this->user_id;
        $r = DB::insert($this->table)
            ->set($ar)
            ->execute();

        return $r[0];
    }

}