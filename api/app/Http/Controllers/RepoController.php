<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use App\Models\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RepoController extends Controller {
    public function __construct() {

    }

    public function getAll(Request $request) {
        try {
            // time to make gitapi?


            $r = [
                'status'  => true,
                'data'    => [],
                'message' => '',
            ];
        } catch (\Exception $e) {
            $e = ExceptionInterceptor::intercept($e);
            $r = [
                'status'    => false,
                'message'   => $e->getMessage(),
                'exception' => $e->getJson(),
                'data'      => [],
            ];
        }

        return $r;
    }

}
