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

$app->get('/tes',function()use($app){
  return "Hallo nama saya ramdhan";
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
{
  $app->get('pelayanan','PelayananController@index');
  $app->get('loket/{id}','AntrianController@loket');
  $app->post('antrian','AntrianController@tambah');
  $app->get('antrian/ambil','AntrianController@ambil');
  $app->post('validasimhs', ['uses' => 'MahasiswaController@validasi']);
  $app->post('auth', 'AuthController@postlogin');
  $app->post('register','AuthController@register');
  $app->get('getantrian/{id}','AntrianController@ambil_antrian');
  $app->post('antrian/selesai','AntrianController@simpan');
  $app->get('temp','AntrianController@getAllTemp');
  $app->get('temp/{id}','AntrianController@getTempByid');
  $app->get('button','AntrianController@button');
  $app->get('ambilakhir','AntrianController@ambilakhir');
  $app->post('tambahmahasiswa','MahasiswaController@tambah');
  $app->get('ambil','TestingController@ambil');
  $app->get('photo','PhotoController@getall');
  $app->post('photo','PhotoController@tambah');
  $app->get('video','VideoController@getvideo');

});
