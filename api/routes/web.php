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
        //        'cors',
        'exceptionHandler',
        //        'auth',
    ],
], function ($router) {
    /**
     * Check if the user is logged in,
     * and also check if the application is setup
     */
    $router->post('auth/check', 'AuthController@checkState');
    $router->post('auth/save-setup', 'AuthController@saveSetup');
    $router->post('auth/init-setup', 'AuthController@doSetup');
    /**
     * check if the dependencies are satisfied
     */
    $router->post('auth/deps', 'AuthController@dependencyCheck');
    $router->post('auth/db-test', 'AuthController@dbTest');

    $router->get('', function () use ($router) {
        return $router->app->version();
    });
});
