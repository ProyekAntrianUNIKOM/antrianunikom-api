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

    public function tambah_pelayanan()
    {
        $nama = $_POST['nama_pelayanan'];
        $keterangan = $_POST['keterangan'];
        $query = app('db')->insert("insert into pelayanan set nama_pelayanan='$nama',keterangan='$keterangan'");    
        if($query)
        {
            return response()->json(['status'=>201,'message'=>'success','result'=>[]]);
        }
        else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }

    public function tambah_loket()
    {
        $nama = $_POST['nama_loket'];
        $pelayanan = $_POST['id_pelayanan'];
        $query = app('db')->insert("insert into loket set nama_loket='$nama',id_pelayanan='$pelayanan'");    
        if($query)
        {
            return response()->json(['status'=>201,'message'=>'success','result'=>[]]);
        }
        else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }
    //
}
