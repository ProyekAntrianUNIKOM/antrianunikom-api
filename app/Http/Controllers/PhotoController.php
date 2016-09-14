<?php

namespace App\Http\Controllers;
use DateTime;
use App\Library\QueueHandler;
use SplQueue;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Request;
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

    public function tambah()
    {
        $file = Request::file('file');
        Storage::put($file->getClientOriginalName(),  File::get($file));
        return response()->json('success');
        
    }
     
}
