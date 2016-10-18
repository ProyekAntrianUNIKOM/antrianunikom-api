<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use File;
use Validator;

class BannerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll() {
      $result = DB::select('SELECT * FROM banner order by id_banner DESC');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function simpanData(Request $request){
      $rules = [
        'file' => ['max:10000','mimes:jpeg,bmp,png']
      ];

      $messages = [
        'file.max' => 'Maximun file size : 10mb'
      ];

      $valid = Validator::make($request->all(),$rules,$messages);
      if ($valid->fails()) {
        return response()->json(['status'=>400,'messages'=> $valid->errors()]);
      }

      $judul = $request->input('judul');
      $foto = $request->file('file');
      $now = Carbon::now()->format('Y-m-d');
      $rand = mt_rand(100000,999999);
      $fileName = $rand.'-'.$foto->getClientOriginalName();
      $request->file('file')->move('banner', $fileName);

      $save = DB::select('INSERT INTO banner SET banner_img=?,judul=?,tgl_posting=?',[$fileName,$judul,$now]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Disimpan.']);
    }

    public function editData(Request $request,$id) {

      $judul = $request->input('judul');
      $foto = $request->file('file');
      $oldfile = $request->input('oldfile');
      //return response()->json($judul);

      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('banner', $fileName);
      }else{
        $fileName = $oldfile;
      }

      $save = DB::select('UPDATE banner SET judul=?,banner_img=? WHERE id_banner=?',[$judul,$fileName,$id]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Diubah.']);
    }

    public function deleteData($id) {
      $poto = DB::select('SELECT * FROM banner WHERE id_banner=?',[$id]);
      if(!$poto){
        return response()->json(['status'=>404,'message'=>'Data tidak ditemukan.']);
      }
      $a = '../public/banner/'.$poto[0]->banner_img;
      unlink($a);

      $delete = DB::select('DELETE FROM banner WHERE id_banner=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Data Berhasil Dihapus.']);
    }

    public function detail($id){
      $result = DB::select('SELECT * FROM banner WHERE id_banner=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }
}
