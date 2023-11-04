<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//$router->group([
//    'middleware' => [
//        'exceptionHandler',
//        'auth',
//    ],
//], function ($router) {
//    $router->post('oauth/all-providers', 'OAuthController@allProviders');
//    $router->post('oauth/save-provider', 'OAuthController@saveProvider');
//    $router->post('oauth/save-oauth-app', 'OAuthController@saveOauthApp');
////    $router->post('oauth/save-oauth-app', 'OAuthController@saveOauthApp');
//    $router->post('oauth/git-accounts', 'OAuthController@gitAccounts');
//    $router->post('oauth/delete-git-accounts', 'OAuthController@deleteGitAccounts');
//    $router->post('proj/create', 'ProjectController@create');
//    $router->post('dash/sidebar', 'ProjectController@sidebar');
//    $router->post('get-project', 'ProjectController@getProject');
//    $router->post('server/test', 'ProjectController@serverTest');
//    $router->post('server/save', 'ProjectController@serverSave');
//    $router->post('servers/list', 'ProjectController@serverList');
//    $router->post('repo/git/all-repos', 'RepoController@getAll');
//    $router->post('repo/git/branches', 'RepoController@getBranches');
//    $router->post('repo/git/commits', 'RepoController@getCommits');
//    $router->post('deploy', 'DeployController@deploy');
//    $router->post('add-deploy-request', 'DeployController@addDeploymentRequest');
//});
//
//$router->group([
//    'middleware' => [
//        'exceptionHandler',
//    ],
//], function ($router) {
//    $router->get('connect', 'OAuthController@connect');
//});
//
//$router->group([
//    'middleware' => [
//        //        'cors',
//        'exceptionHandler',
//    ],
//], function ($router) {
//    /**
//     * Check if the user is logged in,
//     * and also check if the application is setup
//     */
//    $router->post('auth/check', 'AuthController@checkState');
//    $router->post('auth/save-setup', 'AuthController@saveSetup');
//    $router->post('auth/init-setup', 'AuthController@doSetup');
//    $router->post('auth/login', 'AuthController@login');
//    /**
//     * check if the dependencies are satisfied
//     */
//    $router->post('auth/deps', 'AuthController@dependencyCheck');
//    $router->post('auth/db-test', 'AuthController@dbTest');
//
//    $router->get('version', function () use ($router) {
//        return $router->app->version();
//    });
//});
