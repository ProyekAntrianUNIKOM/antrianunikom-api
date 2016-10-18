<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class MahasiswaController extends Controller
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
      $result = DB::select('SELECT * FROM mahasiswa');

      return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
    }

    public function tambah(Request $request)
    {
      $rfid = $request->input('no_rfid');
      $nim = $request->input('nim');
      $nama = $request->input('nama');
      $alamat = $request->input('alamat');
      $jurusan = $request->input('jurusan');
      $cek = DB::select("select * from mahasiswa where nim='$nim'");
      if($cek)
      {
        return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
      }
      $add = DB::insert("insert into mahasiswa set no_rfid='$rfid',nim='$nim',nama='$nama',alamat='$alamat',jurusan='$jurusan'");

      return response()->json(['status'=>200,'message'=>'success','result'=>[]]);
    }
}
