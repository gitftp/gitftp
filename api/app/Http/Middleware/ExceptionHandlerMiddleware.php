<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ExceptionHandlerMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //        Log::info('asd');
        //        try {

        $response = $next($request);
        //        } catch (\Exception $e) {
        //            echo $e->getMessage();
        //        }

        return $response;
    }
}
