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

$app->group(['prefix' => 'api'], function($app) {
    $app->post('/auth', 'App\Http\Controllers\AuthController@postlogin');
    $app->post('/authadmin', 'App\Http\Controllers\AuthController@authadmin');
    $app->post('/validasimhs','App\Http\Controllers\MainController@main');
    //operator
    $app->get('/operator', 'App\Http\Controllers\HistoryController@operator');
    $app->get('/loket', 'App\Http\Controllers\HistoryController@loket');
    $app->post('/history', 'App\Http\Controllers\HistoryController@main');
    $app->post('/historyall', 'App\Http\Controllers\HistoryController@all');
    $app->post('/historydetail', 'App\Http\Controllers\HistoryController@detail');
    //berita
    $app->get('/berita', 'App\Http\Controllers\BeritaController@getAll');
    $app->get('/berita/active', 'App\Http\Controllers\BeritaController@getActive');
    $app->get('/berita/passive', 'App\Http\Controllers\BeritaController@getPassive');
    $app->post('/berita', 'App\Http\Controllers\BeritaController@simpanData');
    $app->post('/berita/{id}', 'App\Http\Controllers\BeritaController@editData');
    $app->get('/berita/{id}', 'App\Http\Controllers\BeritaController@detail');
    $app->delete('/berita/{id}', 'App\Http\Controllers\BeritaController@deleteData');
    //mahasiswa
    $app->get('/mahasiswa', 'App\Http\Controllers\MahasiswaController@getAll');
    $app->post('/mahasiswa', 'App\Http\Controllers\MahasiswaController@tambah');
    //banner
    $app->get('/banner', 'App\Http\Controllers\BannerController@getAll');
    $app->post('/banner', 'App\Http\Controllers\BannerController@simpanData');
    $app->get('/banner/{id}', 'App\Http\Controllers\BannerController@detail');
    $app->post('/banner/{id}', 'App\Http\Controllers\BannerController@editData');
    $app->delete('/banner/{id}', 'App\Http\Controllers\BannerController@deleteData');
    //video
    $app->get('/video', 'App\Http\Controllers\VideoController@getAll');
    $app->post('/video', 'App\Http\Controllers\VideoController@simpanData');
    $app->post('/video/{id}', 'App\Http\Controllers\VideoController@editData');
    $app->get('/video/{id}', 'App\Http\Controllers\VideoController@detail');
    $app->delete('/video/{id}', 'App\Http\Controllers\VideoController@deleteData');
});

$app->group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function($app) {
    $app->get('/', 'App\Http\Controllers\AuthController@postlogin');
});

$app->get('/user', ['as' => 'get_user' , 'uses' => 'UserController@getUser', 'middleware' => 'throttle:2,1']);
