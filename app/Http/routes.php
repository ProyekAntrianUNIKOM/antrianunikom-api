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
  $app->get('operator','PelayananController@operator');

  $app->get('loket','PelayananController@getLoket');
  $app->get('pelayanan','PelayananController@index');
  $app->get('loket/{id}','AntrianController@loket');
  $app->post('antrian','AntrianController@tambah');
  $app->get('antrian/ambil','AntrianController@ambil');

  $app->post('auth', 'AuthController@postlogin');
  $app->post('register','AuthController@register');
  $app->get('getantrian/{id}','AntrianController@ambil_antrian');
  $app->post('antrian/selesai','AntrianController@simpan');
  $app->get('temp','AntrianController@getAllTemp');
  $app->get('temp/{id}','AntrianController@getTempByid');
  $app->get('button','AntrianController@button');
  $app->get('ambilakhir','AntrianController@ambilakhir');
  $app->get('cekhari','AntrianController@cekhari');

  $app->get('ambil','TestingController@ambil');
  $app->get('photo','PhotoController@getall');
  $app->post('photo','PhotoController@simpanData');
  $app->delete('photo/{id}','PhotoController@hapus');


  $app->post('/authadmin', 'AuthController@authadmin');
  $app->post('/history', 'HistoryController@main');
  $app->post('/historyall', 'HistoryController@all');
  $app->post('/historydetail', 'HistoryController@detail');


  //history
  $app->get('/history/operator', 'HistoryController@operator');
  $app->get('/history/loket', 'HistoryController@loket');
  $app->post('/history', 'HistoryController@main');
  $app->post('/historyall', 'HistoryController@all');
  $app->post('/historydetail', 'HistoryController@detail');

  //berita
    $app->get('/berita', 'BeritaController@getAll');
    $app->get('/berita/active', 'BeritaController@getActive');
    $app->get('/berita/passive', 'BeritaController@getPassive');
    $app->post('/berita', 'BeritaController@simpanData');
    $app->post('/berita/{id}', 'BeritaController@editData');
    $app->get('/berita/{id}', 'BeritaController@detail');
    $app->delete('/berita/{id}', 'BeritaController@deleteData');
    //mahasiswa
    $app->get('mahasiswa','MahasiswaController@getAll');
    $app->post('tambahmahasiswa','MahasiswaController@tambah');
    $app->post('validasimhs', ['uses' => 'MahasiswaController@validasi']);
    //banner
    $app->get('/banner', 'BannerController@getAll');
    $app->post('/banner', 'BannerController@simpanData');
    $app->get('/banner/{id}', 'BannerController@detail');
    $app->post('/banner/{id}', 'BannerController@editData');
    //video

    //$app->get('/video', 'VideoController@getAll');
    $app->post('/video', 'VideoController@simpanData');
    $app->post('/video/{id}', 'VideoController@editData');
    $app->get('/video/{id}', 'VideoController@detail');
    $app->delete('/video/{id}', 'VideoController@deleteData');
});
