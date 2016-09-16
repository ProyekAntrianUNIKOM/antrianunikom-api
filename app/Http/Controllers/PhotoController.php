<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;
use File;
class PhotoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function getall()
    {
        $query = DB::select("select * from photo");
        if($query)
        {
            return response()->json(['status'=>200,'message'=>'success','result'=>$query]);
        }else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }

    public function hapus($id)
    {
        $delete = DB::delete("delete from photo where id_photo='$id'");;
        if($delete)
        {
            if($delete)
            {
                return response()->json(['status'=>200,'message'=>'success','result'=>$delete]);
            }else {
                return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
            }
        }
    }

    
    public function simpanData(Request $request) {

      $judul = $request->input('title');
      $foto = $request->file('file');
      $rand = mt_rand(100000,999999);
      if ($request->hasFile('file')) {
        $fileName = $rand.'-'.$foto->getClientOriginalName();
        $request->file('file')->move('img', $fileName);
      }else{
        $fileName = 'default.jpg';
      }
      $save = DB::select('INSERT INTO photo SET title=?,link=?',[$judul,$fileName]);

      return response()->json(['status'=>200,'message'=>'Data Berhasil Disimpan.']);
    }

     
}
