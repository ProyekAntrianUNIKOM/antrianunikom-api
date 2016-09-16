<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use DB;
use Carbon\Carbon;

class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    public function main(Request $request)
    {
      $rules = [
        'id_operator' => 'required'
      ];

      $messages = [
        'id_operator.required' => 'Id Operator cannot be blank.'
      ];

      $valid = Validator::make($request->all(),$rules,$messages);
      if ($valid->fails()) {
        return response()->json(['status'=>400,'messages'=> $valid->errors()]);
      }

      $id_operator = $request->input('id_operator');
      $tahun = $request->input('tahun');
      $bulan = $request->input('bulan');
      $hari = $request->input('hari');

      $info = DB::select("SELECT operator.nama as nama_operator,loket.nama_loket FROM operator
        INNER JOIN loket on loket.no_loket=operator.no_loket
        WHERE operator.id_operator = ?",[$id_operator]);

      $stat = DB::select("SELECT count(id) as jumlah,YEAR(tanggal_pelayanan) as tahun FROM antrian_terlayani WHERE operator = ? GROUP BY YEAR(tanggal_pelayanan)",[$id_operator]);
      return response()->json(['status'=> 200, 'messages' => 'success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator, 'result' => $stat]);

      /*if($tahun && !$bulan && !$hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,loket.nama_loket,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            INNER JOIN loket on antrian.no_loket=loket.no_loket
            INNER JOIN operator on antrian_terlayani.operator=operator.id_operator
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ?",[$id_operator,$tahun]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && !$hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,loket.nama_loket,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            INNER JOIN loket on antrian.no_loket=loket.no_loket
            INNER JOIN operator on antrian_terlayani.operator=operator.id_operator
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && $hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,loket.nama_loket,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            INNER JOIN loket on antrian.no_loket=loket.no_loket
            INNER JOIN operator on antrian_terlayani.operator=operator.id_operator
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ? AND DAY(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan,$hari]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }*/

    }

    public function detail(Request $request)
    {
      $rules = [
        'id_operator' => 'required',
        'tahun' => 'required'
      ];

      $messages = [
        'id_operator.required' => 'Id Operator cannot be blank.',
        'tahun.required' => 'Tahun cannot be blank'
      ];

      $valid = Validator::make($request->all(),$rules,$messages);
      if ($valid->fails()) {
        return response()->json(['status'=>400,'messages'=> $valid->errors()]);
      }

      $id_operator = $request->input('id_operator');
      $tahun = $request->input('tahun');
      $bulan = $request->input('bulan');
      $hari = $request->input('hari');

      $info = DB::select("SELECT operator.nama as nama_operator,loket.nama_loket FROM operator
        INNER JOIN loket on loket.no_loket=operator.no_loket
        WHERE operator.id_operator = ?",[$id_operator]);

      if($tahun && !$bulan && !$hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ?",[$id_operator,$tahun]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && !$hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,loket.nama_loket,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            INNER JOIN loket on antrian.no_loket=loket.no_loket
            INNER JOIN operator on antrian_terlayani.operator=operator.id_operator
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && $hari){
          $result = DB::select("SELECT antrian.no_antrian,mahasiswa.nama as nama_mahasiswa,loket.nama_loket,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN antrian on antrian.id_antrian=antrian_terlayani.id_antrian
            INNER JOIN mahasiswa on antrian.no_rfid=mahasiswa.no_rfid
            INNER JOIN loket on antrian.no_loket=loket.no_loket
            INNER JOIN operator on antrian_terlayani.operator=operator.id_operator
            WHERE antrian_terlayani.operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ? AND DAY(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan,$hari]);
          if(!$result){
            return response()->json(['status'=>400,'messages'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_loket,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }

    }

    public function all(Request $request) {
      $tahun = $request->input('tahun');
      $bulan = $request->input('bulan');
      $hari = $request->input('hari');


      $stat = DB::select("SELECT operator.nama as nama_operator,loket.nama_loket, count(id) as jumlah,YEAR(tanggal_pelayanan) as tahun FROM antrian_terlayani
      LEFT JOIN operator on operator.id_operator=antrian_terlayani.operator
      LEFT JOIN loket on loket.no_loket=operator.no_loket
      WHERE YEAR(tanggal_pelayanan) = ? GROUP BY antrian_terlayani.operator",[$tahun]);
      return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
    }

    public function operator() {
      $stat = DB::select("SELECT id_operator,nama as nama_operator,nama_loket FROM operator
      INNER JOIN loket on operator.no_loket=loket.no_loket");
      return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
    }

    public function loket() {
      $stat = DB::select("SELECT loket.nama_loket,loket.no_loket,count(loket.no_loket) as jumlah,tanggal_pelayanan FROM antrian
      INNER JOIN antrian_terlayani on antrian.id_antrian=antrian_terlayani.id_antrian
      INNER JOIN loket on loket.no_loket=antrian.no_loket
      GROUP BY loket.no_loket");

      /*$op = DB::select("SELECT no_loket,operator.nama as nama_operator FROM operator");

      for ($i=0; $i <count($op) ; $i++) {
        if($op[$i].no_loket == $stat[$i].no_loket){
          $stat[$i].nama_operator == $op[$i].nama_operator;
        }
      }*/

      return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
    }
}
