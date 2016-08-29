<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/validasimhs', ['uses' => 'MainController@main']);

$app->group(['prefix' => 'api'], function($app) {
    $app->post('/auth', 'App\Http\Controllers\AuthController@postlogin');
});

$app->group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function($app) {
    $app->get('/', 'App\Http\Controllers\AuthController@postlogin');
});

$app->get('/user', ['as' => 'get_user' , 'uses' => 'UserController@getUser', 'middleware' => 'throttle:2,1']);
