<?php

namespace Gf;


/**
 * Class Misc
 * contains large functions that are used over the application that have to specific classes.
 */
class Misc {
    /**
     * @return array
     */
    public static function dependencies_check () {
        $allOk = true;
        // testing php.
        $php = 2;
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            $php = 1;
        } else {
            $allOk = false;
        }

        // testing Git
        $git_version = false;
        $git = 2;
        $op = exec('git --version');
        if (strpos($op, 'git version') !== false) {
            $git = 1;
            $git_version = str_replace('git version', '', $op);
        } else {
            $allOk = false;
        }

        //OS name
        $os_name = PHP_OS;

        return [
            'git' => [$git, $git_version],
            'php' => [$php, PHP_VERSION],
            'os'  => $os_name,
            'ok'  => $allOk,
        ];
    }

    /**
     * @param $host
     * @param $db_name
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function test_database ($host, $db_name, $username, $password) {
        $db = new \PDO("mysql:host=$host;dbname=$db_name", $username, $password);

        return true;
    }
}

/* end of file misc.php */
