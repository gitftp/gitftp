<?php

namespace Gf;

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\GitApi;

class Record {
    const db = 'default';
    const table = 'records';

    const type_clone = 1;
    const type_update = 2;
    const type_fresh_upload = 3;
    const type_revert = 4;

    const status_new = 1;
    const status_processing = 2;
    const status_failed = 3;
    const status_success = 4;

    public static function get ($where = [], $select = null, $limit = false, $offset = 0, $order_by = 'id', $direction = 'desc', $count_total = true) {
        $q = \DB::select_array($select)
            ->from(self::table)->where($where);

        if ($limit) {
            $q->limit($limit);
            if ($offset)
                $q->offset($offset);
        }

        if ($order_by)
            $q->order_by($order_by, $direction);

        $compiled_query = $q->compile();
        if ($count_total)
            $compiled_query = Utils::sqlCalcRowInsert($compiled_query);

        $result = \DB::query($compiled_query)->execute(self::db)->as_array();

        return count($result) ? $result : false;
    }

    public static function get_one (Array $where = [], $select = null, $limit = false, $offset = 0, $order_by = 'id', $direction = 'desc', $count_total = true) {
        $a = self::get($where, $select, $limit, $offset, $order_by, $direction, $count_total);

        return ($a) ? $a[0] : false;
    }

    public static function update (Array $where, Array $set) {
        return \DB::update(self::table)->where($where)->set($set)->execute(self::db);
    }

    public static function insert (Array $set) {
        $set['created_at'] = Utils::timeNow();
        list($id) = \DB::insert(self::table)->set($set)->execute(self::db);

        return $id;
    }

    public static function delete (Array $where) {
        $af = \DB::delete(self::table)->where($where)->execute(self::db);

        return $af;
    }
}
