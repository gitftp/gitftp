<?php

class Model_Ftp extends Model {

    private $table = 'ftp';
    public $user_id;
    private $hash = 'fmiorjm8394ru4823ur423894';

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

        foreach($a as $k => $b){
            $a[$k]['pass'] = \Crypt::instance()->decode($a[$k]['pass']);
        }

        return $a;
    }

    public function decypt_password($password) {
        \Crypt::instance()->decode($password, $this->hash);
    }

    public function match($set) {
        $a = DB::select()->from($this->table)->where('user_id', $this->user_id);

        foreach ($set as $k => $v) {
            $a = $a->and_where($k, $v);
        }

        $a = $a->execute()->as_array();

        return $a;
    }

    public function set($id, $set = array(), $direct = FALSE) {
        $a = DB::select()->from($this->table)->where('id', $id);
        if (!$direct) {
            $a = $a->and_where('user_id', $this->user_id);
        }
        $a = $a->execute()->as_array();
        if (!count($a))
            return FALSE;

        if(isset($set['pass']))
            $set['pass'] = \Crypt::instance()->encode($set['pass']);

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    public function delete($id, $direct = FALSE) {
        $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

        if (!$direct) {
            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        return DB::delete($this->table)->where('id', $id)->execute();
    }

    public function insert($ar) {
        $ar['pass'] = \Crypt::instance()->encode($ar['pass']);

        $ar['user_id'] = $this->user_id;
        $r = DB::insert($this->table)
            ->set($ar)
            ->execute();

        return $r[0];
    }

}
