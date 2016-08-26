<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use DB;

class MainController extends Controller
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

    public function main(Request $request) 
    {
        $no_rfid = $request->input('no_rfid');
        $results = DB::select("SELECT * FROM mahasiswa where no_rfid = ?",[$no_rfid]);

        if($results){
            return response()->json(['status'=>200,'message'=>'Success','result'=>$results]);
        }
        return response()->json(['status'=>400,'message'=>'Failed','result'=>[]]);
    }
}
