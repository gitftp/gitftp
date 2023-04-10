<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;

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
            return $this->errorResponse();
        }else{
            $user = DB::select("
                select
                    u.user_id,
                    u.email,
                    u.login_hash as token
                        from users u
                    where u.login_hash = '$token'
            ");
            if(empty($user)){
                return $this->errorResponse();
            }else{
                $request->user = $user[0];
                $request->userId = $user[0]->user_id;
                $request->userToken = $user[0]->token;
            }
        }

        return $next($request);
    }

    private function errorResponse(){
        return response()->json([
            'status'  => false,
            'data'    => [],
            'message' => 'Invalid session',
        ], 200, $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
        ]);
    }
}
