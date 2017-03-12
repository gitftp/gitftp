<?php

namespace Gf;

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\GitApi;

class Server {
    const db = 'default';
    const table = 'servers';

    const type_ftp = 1;
    const type_sftp = 2;
    const type_local = 3;


    public static function get ($where = [], $select = [], $limit = false, $offset = 0, $count_total = true) {
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

    public static function get_one (Array $where = [], $select = null) {
        $a = self::get($where, $select);

        return ($a) ? $a[0] : false;
    }

    public static function update (Array $where, Array $set) {
        $set['updated_at'] = Utils::timeNow();

        return \DB::update(self::table)->where($where)->set($set)->execute(self::db);
    }

    public static function insert (Array $set) {
        $set['created_at'] = Utils::timeNow();
        list($id) = \DB::insert(self::table)->set($set)->execute(self::db);

        return $id;
    }
}
