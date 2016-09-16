<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;
use File;

class BeritaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function getAll() {
      $result = DB::select('SELECT * FROM berita order by tgl_posting ASC');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function detail($id){
      $result = DB::select('SELECT * FROM berita WHERE id_berita=? order by tgl_posting ASC',[$id]);
      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function simpanData(Request $request) {

      $judul = $request->input('judul');
      $isi = $request->input('isi');
      $foto = $request->file('file');
      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = 'default.jpg';
      }
      $save = DB::select('INSERT INTO berita SET judul=?,isi=?,foto=?',[$judul,$isi,$fileName]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Disimpan.']);
    }
    public function deleteData($id) {
      $path = '275644-nodejs_logo.png';
      //if(!$result[0]->foto = 'default.jpg'){
        unlink(__DIR__."../275644-nodejs_logo.png");
      //}
      $delete = DB::select('DELETE FROM berita WHERE id_berita=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Data Berhasil Dihapus.']);
    }

    public function editData(Request $request,$id) {
      $rules = [
        'judul' => 'required',
        'isi' => 'required'
      ];

      $messages = [
        'judul.required' => 'judul cannot be blank.',
        'isi.require' => 'isi cannot be blank'
      ];

      $valid = Validator::make($request->all(),$rules,$messages);
      if ($valid->fails()) {
        return response()->json(['status'=>400,'messages'=> $valid->errors()]);
      }

      $judul = $request->input('judul');
      $isi = $request->input('isi');
      $foto = $request->input('foto');

      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = 'default.jpg';
      }

      $save = DB::select('UPDATE berita SET judul=?,isi=?,foto=? WHERE id_berita=?',[$judul,$isi,$fileName,$id]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Diubah.']);

    }
}
