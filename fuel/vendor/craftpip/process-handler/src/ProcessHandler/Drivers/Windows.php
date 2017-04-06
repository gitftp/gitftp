<?php

namespace Craftpip\ProcessHandler\Drivers;

use Craftpip\ProcessHandler\Exception\ProcessHandlerException;
use Symfony\Component\Process\Process;

class Windows implements DriversInterface {
    function getAllProcesses () {
        $command = "tasklist /V";
        $process = new Process($command);
        $process->run();
        $op = trim($process->getOutput());

        return $this->parseOutput($op);
    }

    function getProcessByPid ($pid) {
        $command = "tasklist /V /fi \"pid eq $pid\"";
        $process = new Process($command);
        $process->run();
        $op = trim($process->getOutput());

        return $this->parseOutput($op);
    }

    function getProcessByProcessName ($processName) {
        $command = "tasklist /V /fi \"imagename eq $processName\"";
        $process = new Process($command);
        $process->run();
        $op = trim($process->getOutput());

        return $this->parseOutput($op);
    }

    private function parseOutput ($output) {
        $op = explode("\n", $output);
        if (count($op) == 1) {
            return [];
        }
        $sessions = explode(" ", $op[1]);
        $cs = [];
        foreach ($sessions as $session) {
            $cs[] = strlen($session);
        }
        $processes = [];

        foreach ($op as $k => $o) {
            if ($k < 2)
                continue;

            $processes[] = [
                'name'         => trim(substr($o, 0, $cs[0] + 1)),
                'pid'          => trim(substr($o, $cs[0] + 1, $cs[1] + 1)),
                'session_name' => trim(substr($o, $cs[0] + $cs[1] + 2, $cs[2] + 1)),
                'session'      => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + 3, $cs[3] + 1)),
                'mem_used'     => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + 4, $cs[4] + 1)),
                'status'       => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + 5, $cs[5] + 1)),
                'username'     => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + 6, $cs[6] + 1)),
                'cpu_time'     => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + $cs[6] + 7, $cs[7] + 1)),
                'window_title' => trim(substr($o, $cs[0] + $cs[1] + $cs[2] + $cs[3] + $cs[4] + $cs[5] + $cs[6] + $cs[7] + 8, $cs[8] + 1)),
            ];
        }

        return $processes;
    }
}