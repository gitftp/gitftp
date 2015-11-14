<?php

namespace Craftpip;

class Exception extends \Exception {
    protected $code;
    protected $message;
    protected $debug = is_debug;

    public function __construct($message = "", $code = 193, $commandLine = NULL, \Exception $previous = NULL) {
        $this->code = $code;
        if ($this->debug) {
//            $this->message = $message.$code.$this->getFile().$this->getLine();
            $this->message = $message;
        } else {
            if ($this->code == 193) {
                $this->message = $message;
            } else {
                logger(600, $message , __METHOD__);
                $this->message = 'Sorry, something went wrong.';
            }
        }
        parent::__construct($this->message, $code, $previous);
    }
}