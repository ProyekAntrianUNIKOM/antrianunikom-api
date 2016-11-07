<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class MahasiswaController extends Controller
{
  public function validasi(Request $request)
  {
      $no_rfid = $request->input('no_rfid');
      $results = DB::select("SELECT * FROM mahasiswa where no_rfid = ?",[$no_rfid]);
      if($results){
          return response()->json(['status'=>200,'message'=>'Success','result'=>$results]);
      }
      else {
        return response()->json(['status'=>400,'message'=>'Failed','result'=>[]]);
      }
  }

  public function getAll()
  {
    $query = DB::select("select * from mahasiswa");
    if($query){
        return response()->json(['status'=>200,'message'=>'Success','result'=>$query]);
    }
    else {
      return response()->json(['status'=>400,'message'=>'Failed','result'=>[]]);
    }
  }

  public function tambah(Request $request)
  {
    $rfid = $request->input('no_rfid');
    $nim = $request->input('nim');
    $nama = $request->input('nama');
    $jurusan = $request->input('prodi');
    $add = DB::insert("insert into mahasiswa set no_rfid='$rfid',nim='$nim',nama='$nama',prodi='$jurusan'");
    $cek = DB::select("select * from mahasiswa where nim='$nim'");
    if($add)
    {
      return response()->json(['status'=>200,'message'=>'success','result'=>[]]);
    }else {
      return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
    }
  }
}
