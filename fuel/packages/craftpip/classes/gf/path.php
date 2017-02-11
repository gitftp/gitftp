<?php
namespace Gf;

class Path {
    public static $table = 'path';
    public static $db = 'default';

    public static function getAll() {
        $data = \DB::select()->from(self::$table)->execute(self::$db)->as_array();

        return $data;
    }

    public static function get($id) {
        $data = \DB::select()->from(self::$table)->where('id', $id)->cached(3600 * 3)->execute(self::$db)->as_array();
        if (count($data)) return $data[0]['path']; else
            return FALSE;
    }

    public static function insert($path) {
        $q = \DB::insert(self::$table)->set([
            'path' => $path
        ])->execute(self::$db);

        return $q;
    }

    public static function update($id, $path) {
        $q = \DB::update(self::$table)->set([
            'path' => $path
        ])->where('id', $id)->execute(self::$db);

        return $q;
    }

    public static function clearCache() {
        \Cache::delete('db');
    }

    public static function remove($id) {
        if (self::get($id)) {
            return \DB::delete(self::$table)->where('id', $id)->execute(self::$db);
        } else {
            return FALSE;
        }
    }
}