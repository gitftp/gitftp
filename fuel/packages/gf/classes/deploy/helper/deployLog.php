<?php

namespace Gf\Deploy\Helper;

use Fuel\Core\Arr;
use Fuel\Core\Cli;
use Fuel\Core\File;
use Fuel\Core\Format;
use Fuel\Core\Fuel;
use Fuel\Core\Num;
use Fuel\Core\Str;
use Gf\Deploy\Tasker\Deployer;
use Gf\Exception\UserException;
use Gf\Git\GitApi;
use Gf\Git\GitLocal;
use Gf\Project;
use Gf\Record;
use Gf\Server;
use Gf\Utils;
use GitWrapper\Event\GitLoggerListener;
use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class DeployLog
 *
 * @package Gf\Deploy
 */
class DeployLog {
    public static $logs = '';
    public static $logFile = false;

    /**
     * @var Logger
     */
    public static $logger;
    /**
     * @var GitLoggerListener
     */
    public static $gitListener;

    public static function getListener () {
        return self::$gitListener;
    }

    public static function createListener () {
        $file = Utils::timeNow() . Str::random('alnum', 7);
        self::$logFile = $file;
        $filePath = DOCROOT . 'logs/' . $file;
        $log = new Logger('DEPLOY');
        $log->pushHandler(new StreamHandler($filePath, Logger::DEBUG));
        self::$logger = $log;
        self::$gitListener = new GitLoggerListener(self::$logger);

        return [self::$gitListener, $file];
    }

//    public static function logToFile ($file = null) {
//        if (is_null($file))
//            $file = Utils::timeNow() . Str::random('alnum', 7);
//
//        self::$logFile = $file;
//
//        return self::$logFile;
//    }

//    public static function logToString () {
//        self::$logFile = '';
//    }

    public static function log ($str, $key = null) {
        if (is_null($key))
            $key = '';
        $key .= ':';

        self::$logger->addInfo("$str", [$key, Num::format_bytes(memory_get_usage()), Num::format_bytes(memory_get_peak_usage()), ini_get('max_execution_time')]);

//        if (self::$logFile) {
//            try {
//                File::append(DOCROOT . 'logs/', self::$logFile, "$key $str\n");
//            } catch (\Exception $e) {
//                File::create(DOCROOT . 'logs/', self::$logFile, "$key $str\n");
//            }
//        } else {
//            self::$logs .= "$key $str\n";
//        }
    }
}