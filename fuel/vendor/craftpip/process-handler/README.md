# process-handler
[![Build Status](https://travis-ci.org/craftpip/process-handler.svg?branch=master)](https://travis-ci.org/craftpip/process-handler)  

Get list of running processes by name or pid, supports windows and unix
  
I struggled to find a library that returns the processes list for the operating system.
My use case was to find if my spawned process was running or not.

## Usage


```php
// Include your autoload 
require_once 'vendor/autoload.php';

use \Craftpip\ProcessHandler\ProcessHandler;
use \Symfony\Component\Process\Process;

// Initialize your library
$processHandler = new ProcessHandler();

// Spawn a process and check if a process by its pid exists.
$process = new Process('ls');
$process->start();
$pid = $process->getPid(); // 8378
$processes = $processHandler->api->getProcessByPid($pid);
if(count($processes)){
    /*
    returns the following on UNIX
    [0] => Array
            (
                [name] => [sh] <defunct>
                [pid] => 8378
                [session_name] => 
                [session] => 6065
                [mem_used] => 0 KB
                [status] => RUNNING
                [username] => root
                [cpu_time] => 00:00:00
                [window_title] => 
            )
            
    returns the following on WINDOWS
    [0] => Array
            (
                [name] => cmd.exe
                [pid] => 6380
                [session_name] => Console
                [session] => 1
                [mem_used] => 3,504 K
                [status] => Unknown
                [username] => BONIFACE-PC\boniface
                [cpu_time] => 0:00:00
                [window_title] => N/A
            )
    */
}else{
    // process was not found.
}


// get all processes 
$allProcesses = $processHandler->api->getAllProcesses();
```

## Methods
```php
$processHandler = new ProcessHandler();
$processHandler->api->getAllProcesses();
$processHandler->api->getProcessByPid($pid);
```

## Installation

Run the composer command 
```cmd
composer require craftpip/process-handler
```

ProcessHandler can be installed with Composer by adding the library as a dependency to your composer.json file.
```json
{
    "require": {
        "craftpip/process-handler": "~1.0"
    }
}
```

## Contribute 

Please feel free to contribute or make additions.


## Copyright and license

Copyright (C) 2017 Boniface Pereira

Licensed under [the MIT license](LICENSE).
