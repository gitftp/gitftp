<?php

namespace App\Exceptions;

class InterceptedException extends \Exception{

    public function getJson(){
        if($this->getPrevious() instanceof UserException){
            return [

            ];
        }else{
            return [
                'message' => $this->getPrevious()->getMessage(),
                'file' => $this->getPrevious()->getFile(),
                'line' => $this->getPrevious()->getLine(),
                'trace' => $this->getPrevious()->getTraceAsString(),
            ];
        }
    }

    public function __construct(\Exception | \TypeError $e) {
        parent::__construct($e->getMessage(), (int)$e->getCode(), $e);
    }
}
