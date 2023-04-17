<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use App\Models\GitLocal;
use App\Models\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DeployController extends Controller {
    public function __construct() {

    }

    public function deploy(Request $request) {
        try {

            $userId = $request->userId;
            $projectId = $request->project_id;
            $serverId = $request->server_id;
            $deployType = $request->deploy_type;
            $revision = $request->revision;


            $project = DB::select("
            select
                p.project_id
            from projects p
            inner join servers s on p.project_id = s.project_id

            where p.project_id = $projectId
            and s.server_id = $serverId
            and p.user_id = $userId
            ");
            if(!count($project)){
                throw new UserException('Project not found');
            }

            $repoPath = Helper::systemDS(
                storage_path() . DIRECTORY_SEPARATOR . Helper::getRepoPath($projectId),
            );
            $gl = new GitLocal($repoPath);
            $rev = $gl->verifyHash($revision);


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
