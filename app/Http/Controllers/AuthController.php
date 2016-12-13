<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exception\HttpResponseException;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Hashing\Bcrypt;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController  extends Controller {

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

         $results = DB::select("SELECT operator.*,loket.no_loket,jenis_pelayanan.nama_pelayanan,jenis_pelayanan.id_jenispelayanan FROM operator
                      inner join loket on loket.no_loket=operator.no_loket
                      inner join jenis_pelayanan on loket.id_jenispelayanan = jenis_pelayanan.id_jenispelayanan where operator.username = ?",[$username]);
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

     public function auth_pmb(Request $request)
     {
         $username = $request->input('username');
         $password = $request->input('password');

         $results = DB::select("select * from operator_pmb where username='$username'");
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

     public function authadmin(Request $request)
     {
         $username = $request->input('username');
         $password = $request->input('password');

         $results = DB::select("SELECT * FROM admin where username = ?",[$username]);
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
