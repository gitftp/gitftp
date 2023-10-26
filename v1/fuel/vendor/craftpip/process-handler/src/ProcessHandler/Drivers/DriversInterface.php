<?php

namespace Craftpip\ProcessHandler\Drivers;

interface DriversInterface {
    /**
     * @return \Craftpip\ProcessHandler\Process[]
     */
    function getAllProcesses ();

    /**
     * @param $pid
     *
     * @return \Craftpip\ProcessHandler\Process[]
     */
    function getProcessByPid ($pid);
}