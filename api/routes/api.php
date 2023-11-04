<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RepoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => [
//        'exceptionHandler',
        'auth',
    ],
], function ($router) {
    $router->post('oauth/all-providers', [OAuthController::class, 'allProviders']);
    $router->post('oauth/save-provider', [OAuthController::class, 'saveProvider']);
    $router->post('oauth/save-oauth-app', [OAuthController::class, 'saveOauthApp']);
//    $router->post('oauth/save-oauth-app', [OAuthController::class, 'saveOauthApp']);
    $router->post('oauth/git-accounts', [OAuthController::class, 'gitAccounts']);
    $router->post('oauth/delete-git-accounts', [OAuthController::class, 'deleteGitAccounts']);
    $router->post('proj/create', [ProjectController::class, 'create']);
    $router->post('dash/sidebar', [ProjectController::class, 'sidebar']);
    $router->post('get-project', [ProjectController::class, 'getProject']);
    $router->post('server/test', [ProjectController::class, 'serverTest']);
    $router->post('server/save', [ProjectController::class, 'serverSave']);
    $router->post('servers/list', [ProjectController::class, 'serverList']);
    $router->post('repo/git/all-repos', [RepoController::class, 'getAll']);
    $router->post('repo/git/branches', [RepoController::class, 'getBranches']);
    $router->post('repo/git/commits', [RepoController::class, 'getCommits']);
    $router->post('deploy', [DeployController::class, 'deploy']);
    $router->post('add-deploy-request', [DeployController::class, 'addDeploymentRequest']);
});

Route::group([
    'middleware' => [
//        'exceptionHandler',
    ],
], function ($router) {
    $router->get('connect', [OAuthController::class, 'connect']);
});

Route::group([
    'middleware' => [
        //        'cors',
//        'exceptionHandler',
    ],
], function ($router) {
    /**
     * Check if the user is logged in,
     * and also check if the application is setup
     */
    $router->post('auth/check', [AuthController::class, 'checkState']);
    $router->post('auth/save-setup', [AuthController::class, 'saveSetup']);
    $router->post('auth/init-setup', [AuthController::class, 'doSetup']);
    $router->post('auth/login', [AuthController::class, 'login']);
    /**
     * check if the dependencies are satisfied
     */

    $router->post('auth/deps', [AuthController::class, 'dependencyCheck']);
    $router->post('auth/db-test', [AuthController::class, 'dbTest']);


    $router->get('version', function () use ($router) {
        return $router->app->version();
    });
});
