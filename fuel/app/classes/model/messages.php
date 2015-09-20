<?php

class Model_Messages extends Model {

    private $table = 'messages';
    public $type_feedback = 1;
    public $user_id;

    public function __construct($user_id = NULL) {
        if (!is_null($user_id)) {
            $this->user_id = $user_id;
        } elseif (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }

    public function get($id = NULL, $type = NULL, $direct = FALSE, $order = 'ASC') {
        $q = DB::select()->from($this->table);

        if (!$direct) {
            $q = $q->where('user_id', $this->user_id);
        }
        if ($id != NULL) {
            $q = $q->and_where('id', $id);
        }

        if ($type != NULL) {
            $q = $q->and_where('type', $type);
        }

        $q = $q->order_by('id', $order);

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
        $a = DB::delete($this->table)->where('id', $id);
        if (!$direct)
            $a = $a->and_where('user_id', $this->user_id);

        return $a->execute();
    }

    public function insert($ar, $user_id = NULL) {
        if (is_null($user_id)) {
            $ar['user_id'] = $this->user_id;
        } else {
            $ar['user_id'] = $user_id;
        }

        $r = DB::insert($this->table)
            ->set($ar)
            ->execute();

        return $r[0];
    }

}
