<?php

namespace App\Models;


class Helper {

    public static function getLastInsertId(){
        return \DB::getPdo()->lastInsertId();
    }

    public static function testDatabaseConnection($host, $db_name, $username, $password, $port){
        $db = new \PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);

        return true;
    }

    /**
     * @return array
     */
    public static function dependenciesCheck () {
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
            'status'  => $allOk,
        ];
    }

}
