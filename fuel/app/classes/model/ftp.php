<?php

class Model_Ftp extends Model {

    private $table = 'ftp';
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
        if (!$direct) $q = $q->and_where('user_id', $this->user_id);

        return $q;
    }

    public function getUnused() {
        $branch = new \Model_Branch();
        $branch_data = $branch->get();
        $ftp_list = $this->get();
        foreach ($branch_data as $bk => $bv) {
            foreach ($ftp_list as $fk => $fv) {
                if ($bv['ftp_id'] == $fv['id']) {
                    unset($ftp_list[$fk]);
                }
            }
        }

        return $ftp_list;
    }

    /**
     * Return true or false if a ftp is in use.
     *
     * @param $id
     */
    public function isUsed($id) {
        $branch = new \Model_Branch();
        $branches = $branch->get_by_ftp_id($id);
        if (count($branches)) return count($branches); else {
            return FALSE;
        }
    }

    public function getParsed($id) {
        $q = \DB::select()->from($this->table)->where('user_id', $this->user_id)->and_where('id', $id)->execute()->as_array();
        foreach ($q as $k => $a) {
            $q[$k]['privatekey'] = $this->parseKeyPath($a['fspath'], $a['priv']);
        }

        return $q;
    }

    public function getKeyContents($pathID, $key) {
        $path = $this->parseKeyPath($pathID, $key);
        if (is_readable($path)) {
            return \File::read($path, TRUE);
        } else {
            throw new \Exception("The file {$path} doesn\'t exists.");
        }
    }

    public function parseKeyPath($pathID, $key) {
        return \Gf\Path::get($pathID) . '/' . $this->user_id . '/' . $key;
    }

    public function get($id = NULL) {

        $q = \DB::select()->from($this->table)->where('user_id', $this->user_id);

        if ($id != NULL) {
            $q = $q->and_where('id', $id);
        }

        $a = $q->execute()->as_array();

        foreach ($a as $k => $b) {
            $a[$k]['pass'] = \Crypt::instance()->decode($a[$k]['pass']);
        }

        return $a;
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
        if (!count($a)) return FALSE;

        if (isset($set['pass'])) $set['pass'] = \Crypt::instance()->encode($set['pass']);

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
        $r = DB::insert($this->table)->set($ar)->execute();

        return $r[0];
    }

}
