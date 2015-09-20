<?php

namespace Craftpip;

class Exception extends \Exception {
    protected $code;
    protected $message;
    protected $debug = TRUE;

    public function __construct($message = "", $code = 193, $commandLine = NULL, \Exception $previous = NULL) {
        $this->code = $code;
        if ($this->debug) {
//            $this->message = $message.$code.$this->getFile().$this->getLine();
            $this->message = $message;
        } else {
            if ($this->code == 193) {
                $this->message = $message;
            } else {
                $this->message = 'Sorry, something went wrong.';
            }
        }
        parent::__construct($this->message, $code, $previous);
    }
}