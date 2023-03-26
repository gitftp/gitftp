<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $token = $request->get('token');
        if (!$token) {
            return response()->json(json_encode([
                'status'  => false,
                'data'    => [],
                'message' => 'Invalid session',
            ]), 200, $headers = [
                'Access-Control-Allow-Origin'      => '*',
                'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Max-Age'           => '86400',
                'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
            ]);
        }

        return $next($request);
    }
}
