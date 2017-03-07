<?php

namespace Gf;

class Projects {
    const db = 'default';
    const table = 'projects';

    public function get ($where = [], $select = [], $limit = false, $offset = 0, $count_total = true) {
        $q = \DB::select_array($select)
            ->from(self::table)->where($where);

        if ($limit) {
            $q->limit($limit);
            if ($offset)
                $q->offset($offset);
        }

        $compiled_query = $q->compile();
        if ($count_total)
            $compiled_query = Utils::sqlCalcRowInsert($compiled_query);

        $result = \DB::query($compiled_query)->execute(self::db)->as_array();

        return count($result) ? $result : false;
    }

    public function get_one (Array $where = [], $select = null) {
        $a = self::get($where, $select);

        return ($a) ? $a[0] : false;
    }

    public function update (Array $where, Array $set) {
        return \DB::update(self::table)->where($where)->set($set)->execute(self::db);
    }

    public function insert (Array $set) {
        list($id) = \DB::insert(self::table)->set($set)->execute(self::db);

        return $id;
    }
}
