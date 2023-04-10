<?php


use Illuminate\Support\Facades\DB;

ini_set('display_errors', 1);

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
//    $router->get('logs', 'LogViewerController@index');
//});

$router->group([
    'middleware' => [
        'exceptionHandler',
        'auth',
    ],
], function ($router) {
    $router->post('oauth/all-providers', 'OAuthController@allProviders');
    $router->post('oauth/save-provider', 'OAuthController@saveProvider');
    $router->post('oauth/save-oauth-app', 'OAuthController@saveOauthApp');
    $router->post('oauth/save-oauth-app', 'OAuthController@saveOauthApp');
    $router->post('oauth/git-accounts', 'OAuthController@gitAccounts');
    $router->post('proj/create', 'ProjectController@create');
    $router->post('dash/sidebar', 'ProjectController@sidebar');
    $router->post('proj/view', 'ProjectController@view');
    $router->post('server/test', 'ProjectController@serverTest');
    $router->post('server/save', 'ProjectController@serverSave');
    $router->post('servers/list', 'ProjectController@serverList');


    $router->post('repo/get-all', 'RepoController@getAll');
    $router->post('repo/get-branches', 'RepoController@getBranches');
    $router->post('repo/get-commits', 'RepoController@getCommits');
});

$router->group([
    'middleware' => [
        'exceptionHandler',
    ],
], function ($router) {
    $router->get('connect', 'OAuthController@connect');
});

$router->group([
    'middleware' => [
        //        'cors',
        'exceptionHandler',
    ],
], function ($router) {
    /**
     * Check if the user is logged in,
     * and also check if the application is setup
     */
    $router->post('auth/check', 'AuthController@checkState');
    $router->post('auth/save-setup', 'AuthController@saveSetup');
    $router->post('auth/init-setup', 'AuthController@doSetup');
    $router->post('auth/login', 'AuthController@login');
    /**
     * check if the dependencies are satisfied
     */
    $router->post('auth/deps', 'AuthController@dependencyCheck');
    $router->post('auth/db-test', 'AuthController@dbTest');

    $router->get('version', function () use ($router) {
        return $router->app->version();
    });
});
