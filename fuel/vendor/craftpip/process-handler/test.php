<?php

require_once "vendor/autoload.php";

$processHandler = new \Craftpip\ProcessHandler\ProcessHandler();
$process = new \Symfony\Component\Process\Process('ls');
$process->start();
$pid = $process->getPid();
print_r($processHandler->api->getProcessByPid($pid));


$processHandler->api->getAllProcesses();