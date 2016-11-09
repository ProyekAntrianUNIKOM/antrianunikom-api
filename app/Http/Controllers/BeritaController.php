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

    public function getActive() {
      $result = DB::select('SELECT * FROM berita WHERE tgl_expire>=CURDATE() order by tgl_posting ASC');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function getPassive() {
      $result = DB::select('SELECT * FROM berita WHERE tgl_expire<CURDATE() order by tgl_posting ASC');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function detail($id){
      $result = DB::select('SELECT * FROM berita WHERE id_berita=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function simpanData(Request $request) {

      $judul = $request->input('judul');
      $isi = $request->input('isi');
      if($isi == 'undefined'){
        return response()->json(['status'=>400,'message'=>'Isi tidak boleh kosong.']);
      }
      $foto = $request->file('file');
      $tgl_expire = $request->input('tgl_expire');
      $now = Carbon::now()->format('Y-m-d');
      if(!$tgl_expire){
        //add expire posting
        $limit = Carbon::parse($now);
        $tgl_expire = $limit->addDays(7)->format('Y-m-d');
      }

      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = 'default.jpg';
      }
      $save = DB::select('INSERT INTO berita SET judul=?,isi=?,foto=?,tgl_posting=?,tgl_expire=?',[$judul,$isi,$fileName,$now,$tgl_expire]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Disimpan.']);
    }
    public function deleteData($id) {
      $poto = DB::select('SELECT foto FROM berita WHERE id_berita=?',[$id]);
      if(!$poto){
        return response()->json(['status'=>404,'message'=>'Data tidak ditemukan.']);
      }
      $a = '../public/img/'.$poto[0]->foto;
      unlink($a);

      $delete = DB::select('DELETE FROM berita WHERE id_berita=?',[$id]);
      return response()->json(['status'=>200,'message'=>'Data Berhasil Dihapus.']);
    }

    public function editData(Request $request,$id) {

      $judul = $request->input('judul');
      $isi = $request->input('isi');
      $foto = $request->file('file');
      $oldfile = $request->input('oldfile');
      //return response()->json($judul);

      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        //hapus foto sebelumnya
        $a = '../public/img/'.$oldfile;
        unlink($a);

        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = $oldfile;
      }

      $save = DB::select('UPDATE berita SET judul=?,isi=?,foto=? WHERE id_berita=?',[$judul,$isi,$fileName,$id]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Diubah.']);
    }
}
