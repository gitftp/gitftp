<?php

namespace Gf\Deploy\Helper;

use Fuel\Core\Str;
use Gf\Utils;
use GitWrapper\Event\GitLoggerListener;
use Monolog\Formatter\LineFormatter;
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

    public static $started;

    public static function getListener () {
        return self::$gitListener;
    }

    public static function createListener () {
        $file = Utils::timeNow() . Str::random('alnum', 7);
        self::$logFile = $file;
        $filePath = DOCROOT . 'logs/' . $file;
        $dateFormat = "d-m-Y, H:i:s";
        $output = "%message%\n";
        $formatter = new LineFormatter($output, $dateFormat);
        $stream = new StreamHandler($filePath, Logger::DEBUG);
        self::$started = round(microtime(true) * 1000);
        $stream->setFormatter($formatter);
        $log = new Logger('DEPLOY');
        $log->pushHandler($stream);
        $log->pushProcessor(function ($message) {
//            $message['extra']['time'] = ((round(microtime(true) * 1000) - DeployLog::$started) / 1000) . "s";
            $m = "(" . ((round(microtime(true) * 1000) - DeployLog::$started) / 1000) . "s) " . $message['message'];
            $m = preg_replace("/x-token-auth:(.*?)@bit/i", '***', $m);
            $m = preg_replace("/https:\/\/(.*?)@git/i", '***', $m);
            $message['message'] = trim($m);

            return $message;
        });
        self::$logger = $log;
        self::$gitListener = new GitLoggerListener(self::$logger);

        return [self::$gitListener, $file];
    }

    public static function log ($str, $key = null) {
        if (is_null($key))
            $key = '';
        else
            $key .= ':';

        self::$logger->info("$key $str");
    }
}