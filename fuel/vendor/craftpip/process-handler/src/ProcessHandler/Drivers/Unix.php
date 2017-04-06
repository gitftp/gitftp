<?php

namespace Craftpip\ProcessHandler\Drivers;

use Symfony\Component\Process\Process;

class Unix implements DriversInterface {
    function getAllProcesses () {
        $process = new Process('ps -eo pid,time,size,user,session,cmd');
        $process->run();
        $op = trim($process->getOutput());

        return $this->parse($op);
    }

    function getProcessByPid ($pid) {
        $process = new Process("ps -p $pid -o pid,time,size,user,session,cmd");
        $process->run();
        $op = trim($process->getOutput());

        return $this->parse($op);
    }

    private function parse ($output) {
        $op = explode("\n", $output);

        $processes = [];
        foreach ($op as $k => $item) {
            if ($k < 1)
                continue;

            $item = explode(" ", $item);
            $line = [];
            foreach ($item as $i) {
                if ($i != '')
                    $line[] = $i;
            }
            $processName = implode(" ", array_slice($line, 5));
            $processes[] = [
                'name'         => $processName,
                'pid'          => $line[0],
                'session_name' => false,
                'session'      => $line[4],
                'mem_used'     => $line[2] . " KB",
                'status'       => 'RUNNING',
                'username'     => $line[3],
                'cpu_time'     => $line[1],
                'window_title' => false,
            ];
        }
        print_r($processes);
    }
}