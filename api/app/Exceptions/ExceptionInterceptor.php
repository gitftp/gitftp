<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class ExceptionInterceptor {


    const defaultMessage = 'Sorry something went wrong, please refresh the page and try again';

    /**
     * @param \Exception $e
     *
     * @return InterceptedException
     */
    public static function intercept(\Exception $e) {
        Log::error($e);
        return new InterceptedException($e);
        // we dont need intercepting of message,
        // because this tool is for developer
    }
}
