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

   

    public function jenispelayanan()
    {
        $result = app('db')->select("select * from jenis_pelayanan");
        $data['status']=200;
        $data['message']='success';
        $data['result']=$result;
        return response()->json($data);
    }

    public function ambilpelayanan($id)
    {
      $result = app('db')->select("select id_pelayanan,pelayanan.nama_pelayanan from pelayanan inner join jenis_pelayanan on jenis_pelayanan.id_jenispelayanan=pelayanan.id_jenispelayanan where pelayanan.id_jenispelayanan='$id'");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$result;
      return response()->json($data);
    }

    public function ambilsubpelayanan($id)
    {
        $result = app('db')->select("select id_subpelayanan,nama_subpelayanan from sub_pelayanan inner join pelayanan on pelayanan.id_pelayanan = sub_pelayanan.id_pelayanan where sub_pelayanan.id_pelayanan='$id'");
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

    public function operator()
    {
        $query = app('db')->select("select * from operator natural join loket");
        if($query)
        {
            return response()->json(['status'=>200,'message'=>'success','result'=>$query]);
        }
        else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }
    public function getLoket()
    {
        $query = app('db')->select("select * from loket");
        if($query)
        {
            return response()->json(['status'=>200,'message'=>'success','result'=>$query]);
        }
        else {
            return response()->json(['status'=>400,'message'=>'error','result'=>[]]);
        }
    }
    //
}
