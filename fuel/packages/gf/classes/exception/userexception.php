<?php

namespace Gf\Exception;

class UserException extends \Exception {
    protected $code;
    protected $message;

    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($this->message, $this->code, $previous);
    }
}