<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterceptor;
use App\Exceptions\UserException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepoController extends Controller {
    public function __construct() {

    }

    public function getCommits(Request $request) {
        try {
            $projectId = $request->project_id;
            $branchName = $request->branch;

            $ac = DB::select("
            select
                oaa.account_id,
                p.git_name,
                oaa.git_username
                from oauth_app_accounts oaa
            inner join projects p on oaa.account_id = p.account_id
            where p.project_id = '$projectId'
            ");
            $ac = $ac[0];
            $accountId = $ac->account_id;

            $ga = new \App\Helpers\Git\GitApi($accountId);
            $commits = $ga->getProvider()->commits($ac->git_name, $branchName, $ac->git_username);

            $r = [
                'status'  => true,
                'data'    => [
                    'commits' => $commits,
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

    public function getBranches(Request $request) {
        try {
            $projectId = $request->project_id;
            $fullName = $request->full_name;
            $accountId = $request->account_id;

            if ($projectId) {
                $projObj = DB::select("
                    select
                        p.git_name,
                        p.git_username,
                        p.account_id
                        from projects p
                        where p.project_id = '$projectId'
                ");
                if (empty($projObj))
                    throw new UserException('The project was not found');
                $username = $projObj[0]->git_username;
                $repository_name = $projObj[0]->git_name;
                $accountId = $projObj[0]->account_id;
            }
            else {
                list($username, $repository_name) = explode('/', $fullName);
            }

            $ga = new \App\Helpers\Git\GitApi($accountId);
            $branches = $ga->getProvider()
                           ->getBranches($repository_name, $username);

            $r = [
                'status'  => true,
                'data'    => [
                    'branches' => $branches,
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

    public function getAll(Request $request) {
        try {
            // time to make gitapi?
            $userId = $request->userId;
            $accounts = DB::select("
                select
                    oaa.account_id
                from oauth_app_accounts oaa
                    inner join oauth_apps oa on oaa.oauth_app_id = oa.oauth_app_id
                where oa.user_id = '$userId'
            ");

            $repos = [];
            foreach ($accounts as $account) {
                $ga = new \App\Helpers\Git\GitApi($account->account_id);
                $r = $ga->getProvider()
                        ->getRepositories();
                $r = array_map(function ($a) use ($account) {
                    $a['account_id'] = $account->account_id;

                    return $a;
                }, $r);
                $repos = array_merge($repos, $r);
            }

            $r = [
                'status'  => true,
                'data'    => [
                    'repos' => $repos,
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
