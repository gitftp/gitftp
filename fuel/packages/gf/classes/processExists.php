<?php
namespace Gf;

use Symfony\Component\Process\Process;

class ProcessExists {

    /**
     * Check if the a pid exists.
     *
     * @return string process name
     *
     * @param $pid
     */
    public static function isRunning ($pid) {
        $process = new Process();
    }

    public static function isWindows () {
        return !!strpos(PHP_OS, 'WIN');
    }
}