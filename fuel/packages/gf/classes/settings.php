<?php
namespace Gf;

class Settings {
    public static $table = 'options';
    public static $db = 'default';
    public static $cacheName = 'settings';

    public static function getAll () {
        $data = \DB::select()
            ->from(self::$table)
            ->order_by('name')
            ->execute(self::$db)
            ->as_array();

        return $data;
    }

    /**
     * @param      $name
     * @param bool $default
     *
     * @return String
     */
    public static function get ($name, $default = false) {
        try {
            $c = \Cache::get(self::$cacheName, true);
        } catch (\Exception $e) {
            $ar = self::getAll();
            $c = self::parse($ar);
            \Cache::set(self::$cacheName, $c, 3600 * 30);
        }

        if (array_key_exists($name, $c)) {
            if ($c[$name] == '0') {
                return false;
            } else {
                return $c[$name];
            }
        } else {
            return $default;
        }
    }

    public static function set ($name, $value) {
        $e = \DB::select()
            ->from(self::$table)
            ->where('name', $name)
            ->execute(self::$db)
            ->as_array();

        if (count($e)) {
            $q = \DB::update(self::$table)
                ->set([
                    'name'  => $name,
                    'value' => $value,
                ])
                ->where('name', $name)
                ->execute(self::$db);
        } else {
            $q = \DB::insert(self::$table)
                ->set([
                    'name'  => $name,
                    'value' => $value,
                ])
                ->execute(self::$db);
        }
        self::clearCache();

        return $q;
    }

    public static function clearCache () {
        \Cache::delete(self::$cacheName);
    }

    public static function parse ($ar) {
        $a = [];
        foreach ($ar as $b) {
            $a[$b['name']] = $b['value'];
        }

        return $a;
    }

    public static function remove ($name) {
        if (self::get($name)) {
            return \DB::delete(self::$table)
                ->where('name', $name)
                ->execute(self::$db);
        } else {
            return false;
        }
    }
}