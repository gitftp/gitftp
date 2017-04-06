<?php

namespace Craftpip\ProcessHandler;

use Craftpip\ProcessHandler\Drivers\DriversInterface;
use Craftpip\ProcessHandler\Drivers\Unix;
use Craftpip\ProcessHandler\Drivers\Windows;
use Symfony\Component\Process\Process;

class ProcessHandler {
    /**
     * @var string
     */
    public $operatingSystem;

    /**
     * @var DriversInterface
     */
    public $api;

    const systemWindows = "Win";
    const systemUnix = "Unix";

    /**
     * ProcessHandler constructor.
     */
    public function __construct () {
        $this->operatingSystem = $this->isWindows() ? self::systemWindows : self::systemUnix;

        if ($this->operatingSystem == self::systemWindows) {
            $this->api = new Windows();
        } else {
            $this->api = new Unix();
        }
    }

    private function isWindows () {
        return !(strpos(PHP_OS, 'WIN') === false);
    }

}
