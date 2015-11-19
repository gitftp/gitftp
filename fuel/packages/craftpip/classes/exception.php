<?php

namespace Craftpip;

use Gf\Settings;

class Exception extends \Exception {
    protected $code;
    protected $message;

    public function __construct($message = "", $code = 193, $commandLine = NULL, \Exception $previous = NULL) {
        $debug = Settings::get('gf_exeption_debug');
        $erMessage = Settings::get('gf_exception_message');

        $this->code = $code;
        if ($debug) {
            $this->message = $message;
        } else {
            if ($this->code == 193) {
                $this->message = $message;
            } else {
                logger(600, $message, __METHOD__);
                $this->message = $erMessage;
            }
        }
        parent::__construct($this->message, $code, $previous);
    }
}