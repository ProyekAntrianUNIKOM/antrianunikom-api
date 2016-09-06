<?php

namespace App\Http\Controllers;

class PelayananController extends Controller
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

    public function index()
    {
        $result = app('db')->select("select * from pelayanan");
        $data['status']=200;
        $data['message']='success';
        $data['result']=$result;
        return response()->json($data);
    }

    public function loket($id)
    {
      $result = app('db')->select("select loket.no_loket,user.nama as operator,loket.nama_loket 
                                  from loket inner join user on loket.operator = user.id_user where loket.id_pelayanan='$id'");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$result;
      return response()->json($data);
    }
    //
}
