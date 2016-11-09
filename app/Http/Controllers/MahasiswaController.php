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
    $prodi = $request->input('prodi');
    $cek = DB::select("select * from mahasiswa where no_rfid='$rfid'");
    if($cek)
    {
      return response()->json(['status'=>400,'message'=>'Nomor RFID sudah terdaftar.','result'=>[]]);
    }
    $add = DB::insert("insert into mahasiswa set no_rfid='$rfid',nim='$nim',nama='$nama',prodi='$prodi'");

    return response()->json(['status'=>200,'message'=>'success','result'=>[]]);
  }

  public function editData(Request $request,$id) {

    $nim = $request->input('nim');
    $nama = $request->input('nama');
    $prodi = $request->input('prodi');

    $save = DB::select('UPDATE mahasiswa SET nim=?,nama=?,prodi=? WHERE no_rfid=?',[$nim,$nama,$prodi,$id]);

    return response()->json(['status'=>200,'message'=>'Data Berhasil Diubah.']);
  }

  public function detail($id){
    $result = DB::select('SELECT * FROM mahasiswa WHERE no_rfid=?',[$id]);
    return response()->json(['status'=>200,'message'=>'Success','result'=>$result]);
  }

  public function deleteData($id) {

    $delete = DB::select('DELETE FROM mahasiswa WHERE no_rfid=?',[$id]);
    return response()->json(['status'=>200,'message'=>'Data Berhasil Dihapus.']);
  }
}
