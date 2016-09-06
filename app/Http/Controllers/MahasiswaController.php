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
}
