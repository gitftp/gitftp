<?php

namespace App\Helpers;


class Helper {



    /**
     * System directory separator.
     * will change the DIRECTORY_SEPARATOR to the one that the OS understands
     *
     * @param $path
     *
     * @return mixed
     */
    public static function systemDS($path) {
        $replace = "\\";
        if (DIRECTORY_SEPARATOR == "\\")
            $replace = "/";

        return str_replace($replace, DIRECTORY_SEPARATOR, $path);
    }

    public static function getRepoPath($project_id) {
        return "repositories" . DIRECTORY_SEPARATOR . "$project_id" . DIRECTORY_SEPARATOR;
    }

    public static function encode($a) {
        $a = urlencode($a);
        $a = base64_encode($a);

        return $a;
    }

    public static function decode($a) {
        $a = base64_decode($a);
        $a = urldecode($a);

        return $a;
    }

    public static function getDateTime() {
        return date('Y-m-d H:i:s');
    }

    public static function getDateTimeFromTime($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function getLastInsertId() {
        return \DB::getPdo()
                  ->lastInsertId();
    }

    public static function testDatabaseConnection($host, $db_name, $username, $password, $port) {
        $s = "mysql:host=$host;dbname=$db_name;port=$port";
        $db = new \PDO($s, $username, $password);

        return true;
    }

    /**
     * @return array
     */
    public static function dependenciesCheck() {
        $allOk = true;
        // testing php.
        $php = 2;
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            $php = 1;
        }
        else {
            $allOk = false;
        }

        // testing Git
        $git_version = false;
        $git = 2;
        $op = exec('git --version');
        if (strpos($op, 'git version') !== false) {
            $git = 1;
            $git_version = str_replace('git version', '', $op);
        }
        else {
            $allOk = false;
        }

        //OS name
        $os_name = PHP_OS;

        return [
            'git'    => [
                $git,
                $git_version,
            ],
            'php'    => [
                $php,
                PHP_VERSION,
            ],
            'os'     => $os_name,
            'status' => $allOk,
        ];
    }

}
