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

class ProjectController extends Controller {
    public function __construct() {

    }

    public function example(Request $request) {
        try {

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

    public function view(Request $request) {
        try {
            $projectId = $request->project_id;

            $projects = DB::select("
            select
                p.*
                , p2.*
            from projects p
                inner join oauth_app_accounts oaa on p.account_id = oaa.account_id
                inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
                inner join providers p2 on oa.provider_id = p2.provider_id
                where p.project_id = '$projectId'
            ");

            if (empty($projects)) {
                throw new UserException('Project not found');
            }
            else {
                $project = $projects[0];
            }

            $r = [
                'status'  => true,
                'data'    => [
                    'project' => $project,
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

    public function sidebar(Request $request) {
        try {

            $userId = $request->userId;
            $projects = DB::select("
            select
            p.project_id
            , p.project_id
            , p.name
            from projects p
                where p.user_id = '$userId'
            ");


            $r = [
                'status'  => true,
                'data'    => [
                    'projects' => $projects,
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


    public function create(Request $request) {
        try {
            $projectName = $request->project_name;
            $repo = $request->repo;
            list($username, $repoName) = explode('/', $request->repo['full_name']);
            DB::table('projects')
              ->insert([
                  'name'         => $projectName,
                  'account_id'   => $request->repo['account_id'],
                  'path'         => $request->repo['repo_url'],
                  'uri'          => $request->repo['api_url'],
                  'clone_url'    => $request->repo['clone_url'],
                  'git_uri'      => $request->repo['clone_url'],
                  'git_username' => $username,
                  'git_name'     => $repoName,
                  'git_id'       => $request->repo['id'],
                  'created_at'   => Helper::getDateTime(),
                  'created_by'   => $request->userId,
                  'user_id'      => $request->userId,
              ]);
            $projectId = Helper::getLastInsertId();

            $r = [
                'status'  => true,
                'data'    => [
                    'project_id' => $projectId,
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
}
