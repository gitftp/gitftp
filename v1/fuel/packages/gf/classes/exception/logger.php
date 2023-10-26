<?php
namespace Gf\Exception;

use Gf\Utils;

/**
 * Class Logger
 * This is a CRUD class to just add and update exception logs
 *
 * @package Gf\Exception
 */
class Logger {
    public static $table = 'exception_logs';
    public static $db = 'default';


    public static function insert ($set) {
        $set['created_at'] = Utils::timeNow();
        $q = \DB::insert(self::$table)
            ->set($set)
            ->execute(self::$db);

        return $q;
    }

    public static function update ($id, $set) {
        $q = \DB::update(self::$table)
            ->set($set);

        $q = $q->where('id', $id);

        $q = $q->execute(self::$db);

        return $q;
    }

    public static function remove ($id) {
        return \DB::delete(self::$table)
            ->where('id', $id)
            ->execute(self::$db);
    }
}