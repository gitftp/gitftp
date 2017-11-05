<?php

namespace Craftpip\ProcessHandler;

use Craftpip\ProcessHandler\Drivers\DriversInterface;
use Craftpip\ProcessHandler\Drivers\Unix;
use Craftpip\ProcessHandler\Drivers\Windows;
use Craftpip\ProcessHandler\Exception\ProcessHandlerException;

class Process {

    private $name;

    private $pid;

    private $session_name;

    private $session;

    private $mem_used;

    private $status;

    private $username;

    private $cpu_time;

    private $window_title;

    /**
     * Process constructor.
     *
     * @param $name
     * @param $pid
     * @param $session_name
     * @param $session
     * @param $mem_used
     * @param $status
     * @param $username
     * @param $cpu_time
     * @param $window_title
     */
    public function __construct ($name, $pid, $session_name, $session, $mem_used, $status, $username, $cpu_time, $window_title) {
        $this->name = $name;
        $this->pid = $pid;
        $this->session_name = $session_name;
        $this->session = $session;
        $this->mem_used = $mem_used;
        $this->status = $status;
        $this->username = $username;
        $this->cpu_time = $cpu_time;
        $this->window_title = $window_title;
    }

    /**
     * @return bool
     */
    public function isRunning () {
        return (new ProcessHandler())->isRunning($this->getPid());
    }

    /**
     * @return mixed
     */
    public function getName () {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPid () {
        return $this->pid;
    }

    /**
     * @return mixed
     */
    public function getSessionName () {
        return $this->session_name;
    }

    /**
     * @return mixed
     */
    public function getSession () {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getMemUsed () {
        return $this->mem_used;
    }

    /**
     * @return mixed
     */
    public function getStatus () {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getUsername () {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getCpuTime () {
        return $this->cpu_time;
    }

    /**
     * @return mixed
     */
    public function getWindowTitle () {
        return $this->window_title;
    }

}
