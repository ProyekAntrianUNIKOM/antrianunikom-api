<?php

namespace App\Http\Controllers;
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
}
