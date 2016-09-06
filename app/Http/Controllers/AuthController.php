<?php
namespace App\Http\Controllers;
use Illuminate\Http\Exception\HttpResponseException;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Hashing\Bcrypt;
use DB;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $results = DB::select("SELECT operator.id_operator,operator.no_loket,operator.nama,operator.alamat,operator.telpon,loket.nama_loket,operator.password  FROM operator 
                        inner join loket on operator.no_loket=loket.no_loket where operator.username = ?",[$username]);
        if(!$results){
            return response()->json(['status'=>400,'message'=>'Username not found','result'=>[]]);
        }
        //return response()->json(['hashedPassword'=>$password, 'passworddb'=>$results[0]->password]);
        if(Hash::check($password,$results[0]->password)){
            return response()->json(['status'=>200,'message'=>'Success','result'=>$results]);
        }else{
            return response()->json(['status'=>400,'message'=>'Wrong password','result'=>[]]);
        }
    }

    public function register(Request $request)
    {
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $telpon = $request->input('telpon');
        $username = $request->input('username');
        $noloket  = $request->input('no_loket');
        $password = app('hash')->make($request->input('password'));
        $query = DB::insert("insert into operator set nama='$nama',
                    alamat='$alamat',
                    telpon='$telpon',
                    username='$username',
                    password='$password'");
        if($query){
             return response()->json(['status'=>201,'message'=>'Success','result'=>[]]);
        }else{
            return response()->json(['status'=>400,'message'=>'Error','result'=>[]]);
        }
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }
}