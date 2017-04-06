<?php

namespace Craftpip\ProcessHandler\Drivers;

interface DriversInterface {
    /**
     * @return array
     */
    function getAllProcesses ();

    function getProcessByPid ($pid);
}