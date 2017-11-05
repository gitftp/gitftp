<?php

require_once "vendor/autoload.php";

$processHandler = new \Craftpip\ProcessHandler\ProcessHandler();
$process = new \Symfony\Component\Process\Process('wait 5');
$process->start();
$pid = $process->getPid();
echo $pid;
$process = $processHandler->getProcess(12796);
print_r($process);
print_r($process->isRunning());
print_r($process->getWindowTitle());

