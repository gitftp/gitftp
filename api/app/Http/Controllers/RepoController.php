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

            $ga = new \GitApi($accountId);
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
                $ga = new \GitApi($account->account_id);
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
