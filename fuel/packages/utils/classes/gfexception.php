<?php

namespace Craftpip;

class GfException extends \Exception {
    protected $commandLine;

    public function __construct($message = "", $code = 193, $commandLine = NULL, \Exception $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
}