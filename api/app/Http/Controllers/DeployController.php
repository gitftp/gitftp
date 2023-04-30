<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use App\Models\Deploy\Deploy;
use App\Models\Git\GitLocal;
use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DeployController extends Controller {
    public function __construct() {

    }


    public function addDeploymentRequest(Request $request) {
        try {
            $userId = $request->userId;
            $projectId = $request->project_id;
            $serverId = $request->server_id;
            $type = $request->type;
            $revision = $request->revision;

            $pro = DB::select("
                select
                    p.clone_state
                    from projects p
                where p.project_id = $projectId
                and p.user_id = $userId
            ");
            $cloneState = $pro[0]->clone_state;
            if (!$cloneState and $type != Deploy::TYPE_CLONE) {
                throw new UserException("please clone the project first.");
            }

            // check if there is
//            DB::table('deployments')
//              ->insert([
//                  'server_id'   => $serverId,
//                  'project_id'  => $projectId,
//                  'type'        => $type,
//                  'to_revision' => $revision,
//              ]);

            Artisan::call('deploy:run ' . $projectId);

            $r = [
                'status'  => true,
                'data'    => [//                    'depId' => $deploymentId,
                ],
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
            if (!count($project)) {
                throw new UserException('Project not found');
            }

            $repoPath = Helper::systemDS(storage_path() . DIRECTORY_SEPARATOR . Helper::getRepoPath($projectId),);
            $gl = new GitLocal($repoPath);
            $rev = $gl->verifyHash($revision);
            // @todo we are here.
            // we have to clone the repo first,
            /// i will be back here.


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
