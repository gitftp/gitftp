<?php

class FileTask extends Thread {
    public $val;

    public function __construct ($val) {
        $this->val = $val;
        $this->done = false;
    }

    public function run () {
        if (!$this->worker->ready)
            return false;

        sleep(1);

        $this->done = true;
        var_dump('Its me' . $this->val);
    }
}
