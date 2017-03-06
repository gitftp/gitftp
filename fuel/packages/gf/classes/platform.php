<?php
namespace Gf;

class Platform {

    public static $not_defined = 40;
    public static $web = 1;
    public static $android = 2;
    public static $ios = 3;
    public static $wp = 4;

    /**
     * @param null $id
     *
     * @return array
     */
    public static function platform ($id = null) {
        $a = [
            self::$not_defined => 'Not defined',
            self::$web         => 'Web',
            self::$android     => 'Android',
            self::$ios         => 'IOS',
            self::$wp          => 'Windows Phone',
        ];
        if (is_null($id))
            return $a;
        else
            return $a[$id];
    }


}