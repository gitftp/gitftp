<?php

namespace Gf\Deploy\Tasker;

class FileTask extends \Thread {

    public $fileName;

    public $actionType;

    public function __construct ($fileAction) {
        $this->fileName = $fileAction['path'];
        $this->actionType = $fileAction['type'];
    }

    public function run () {
        echo 'hey';
        sleep(1);
    }
}
