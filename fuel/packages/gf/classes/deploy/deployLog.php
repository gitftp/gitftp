<?php

namespace Gf\Deploy;

use Fuel\Core\Arr;
use Fuel\Core\Cli;
use Fuel\Core\File;
use Fuel\Core\Fuel;
use Fuel\Core\Str;
use Gf\Deploy\Tasker\Deployer;
use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Git\GitLocal;
use Gf\Project;
use Gf\Record;
use Gf\Server;
use Gf\Utils;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;

/**
 * Class DeployLog
 *
 * @package Gf\Deploy
 */
class DeployLog {
    public static $logs = '';
    public static $logFile = false;

    public static function logToFile ($file = null) {
        if (is_null($file))
            $file = Utils::timeNow() . Str::random('alnum', 7);

        self::$logFile = $file;

        return self::$logFile;
    }

    public static function logToString () {
        self::$logFile = '';
    }

    public static function log ($str, $key = null) {
        if (is_null($key))
            $key = '';
        $key .= ':';

        if (self::$logFile) {
            try {
                File::append(DOCROOT . 'logs/', self::$logFile, "$key $str\n");
            } catch (\Exception $e) {
                File::create(DOCROOT . 'logs/', self::$logFile, "$key $str\n");
            }
        } else {
            self::$logs .= "$key $str\n";
        }
    }

    public static function clearLog () {
        self::$logs = '';
    }

    public static function getLog () {
        return self::$logs;
    }
}