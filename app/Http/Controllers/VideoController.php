<?php

namespace App\Http\Controllers;
use DateTime;
use App\Library\QueueHandler;
use SplQueue;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Request;
class VideoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function getvideo()
    {
        $query = DB::select("select * from video");
        if($query)
        {
            return response()->json(['status'=>200,'message'=>'success','result'=>$query]);
        }else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }
     
}
