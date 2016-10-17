<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;
use File;

class VideoController extends Controller
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
      $result = DB::select('SELECT * FROM video order by tgl_posting ASC');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }


    public function detail($id){
      $result = DB::select('SELECT * FROM video WHERE id_video=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function simpanData(Request $request) {

      $judul = $request->input('judul');
      $video = $request->file('file');
      $now = Carbon::now()->format('Y-m-d');

      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$video->getClientOriginalName();
        $request->file('file')->move('video', $fileName);
      }else{
        return response()->json(['status'=>400,'message'=>'Video tidak boleh kosong.']);
      }
      $save = DB::select('INSERT INTO video SET judul=?,video=?,tgl_posting=?',[$judul,$fileName,$now]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Disimpan.']);
    }
    public function deleteData($id) {
      //$dir = '../../../public/img/275644-nodejs_logo.png';
      //if(!$result[0]->foto = 'default.jpg'){
        //unlink($dir);
      //}
      $delete = DB::select('DELETE FROM video WHERE id_video=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Data Berhasil Dihapus.']);
    }

    public function editData(Request $request,$id) {

      $judul = $request->input('judul');
      $video = $request->file('file');
      $oldfile = $request->input('oldfile');
      //return response()->json($judul);

      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$video->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = $oldfile;
      }

      $save = DB::select('UPDATE video SET judul=?,video=? WHERE id_video=?',[$judul,$fileName,$id]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Diubah.']);

    }
}
