<?php

namespace Gf\Exception;

class AppException extends \Exception {
    protected $code;
    protected $message;
    protected $backtrace;
    /**
     * @var null
     */
    protected $dump_data;

    /**
     * AppException constructor.
     *
     * @param string          $message
     * @param null            $dump_data    -> dump all required data into this, so its easy to debug
     *                                      this really helps in finding errors in data.
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $dump_data = null, $code = 0, \Exception $previous = null) {
        $this->message = $message;
        $this->code = $code;
        $this->dump_data = $dump_data;
        parent::__construct($this->message, $this->code, $previous);
        $this->backtrace = debug_backtrace();
    }

    public function getDumpData() {
        return $this->dump_data ? $this->dump_data : false;
    }

    /**
     * @return array
     */
    public function getBacktrace() {
        return $this->backtrace;
    }
}