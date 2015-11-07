<?php

class Model_Messages extends Model {

    private $table = 'messages';
    public $conn = 'frontend';
    public $type_feedback = 1;
    public $type_pagefeedback = 2;
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

    public function select($select = NULL, $direct = FALSE) {
        $q = \DB::select($select)->from($this->table);
        if (!$direct)
            $q = $q->and_where('user_id', $this->user_id);

        return $q;
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

        $a = $q->execute($this->conn)->as_array();

        foreach ($a as $_k => $_v) {
            if (Str::is_serialized($a[$_k]['extras']))
                $a[$_k]['extras'] = unserialize($a[$_k]['extras']);
        }

        return $a;
    }

    public function set($id, $set = array(), $direct = FALSE) {
        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute($this->conn);
    }

    public function delete($id, $direct = FALSE) {
        $a = DB::delete($this->table)->where('id', $id);
        if (!$direct)
            $a = $a->and_where('user_id', $this->user_id);

        return $a->execute($this->conn);
    }

    public function insert($ar, $user_id = NULL) {
        if (is_null($user_id)) {
            $ar['user_id'] = $this->user_id;
        } else {
            $ar['user_id'] = $user_id;
        }
        if (isset($ar['extras']))
            $ar['extras'] = serialize($ar['extras']);

        $r = DB::insert($this->table)
            ->set($ar)
            ->execute($this->conn);

        return $r[0];
    }

}
