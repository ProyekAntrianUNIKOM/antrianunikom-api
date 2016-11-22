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

      $info = DB::select("SELECT operator.nama as nama_operator,pelayanan.nama_pelayanan FROM operator
        INNER JOIN loket on loket.no_loket=operator.no_loket
        INNER JOIN pelayanan on loket.id_pelayanan=pelayanan.id_pelayanan
        WHERE operator.id_operator = ?",[$id_operator]);

      if($tahun && !$bulan && !$hari){
          $result = DB::select("SELECT antrian_terlayani.no_antrian,mahasiswa.nama as nama_mahasiswa,mahasiswa.nim,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN mahasiswa on antrian_terlayani.no_rfid=mahasiswa.no_rfid
            INNER JOIN operator on antrian_terlayani.no_loket=operator.no_loket
            WHERE operator.id_operator = ? AND YEAR(tanggal_pelayanan) = ?",[$id_operator,$tahun]);
          if(!$result){
            return response()->json(['status'=>400,'message'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_pelayanan,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && !$hari){
          $result = DB::select("SELECT antrian_terlayani.no_antrian,mahasiswa.nama as nama_mahasiswa,mahasiswa.nim,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN mahasiswa on antrian_terlayani.no_rfid=mahasiswa.no_rfid
            INNER JOIN operator on antrian_terlayani.no_loket=operator.no_loket
            WHERE operator.id_operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan]);
          if(!$result){
            return response()->json(['status'=>400,'message'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_pelayanan,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif($tahun && $bulan && $hari){
          $result = DB::select("SELECT antrian_terlayani.no_antrian,mahasiswa.nama as nama_mahasiswa,mahasiswa.nim,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
            INNER JOIN mahasiswa on antrian_terlayani.no_rfid=mahasiswa.no_rfid
            INNER JOIN operator on antrian_terlayani.no_loket=operator.no_loket
            WHERE operator.id_operator = ? AND YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ? AND DAY(tanggal_pelayanan) = ?",[$id_operator,$tahun,$bulan,$hari]);
          if(!$result){
            return response()->json(['status'=>400,'message'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_pelayanan,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }elseif(!$tahun && !$bulan && !$hari){
        $result = DB::select("SELECT antrian_terlayani.no_antrian,mahasiswa.nama as nama_mahasiswa,mahasiswa.nim,operator.nama as nama_operator,tanggal_pelayanan FROM antrian_terlayani
          INNER JOIN mahasiswa on antrian_terlayani.no_rfid=mahasiswa.no_rfid
          INNER JOIN operator on antrian_terlayani.no_loket=operator.no_loket
          WHERE operator.id_operator = ?",[$id_operator]);
          if(!$result){
            return response()->json(['status'=>400,'message'=> 'Data not found.']);
          }
          return response()->json(['status'=>200,'message'=>'Success','nama_loket' => $info[0]->nama_pelayanan,'nama_operator' => $info[0]->nama_operator,'jumlah'=> count($result),'result'=>$result]);
      }

    }

    public function all(Request $request) {
      $tahun = $request->input('tahun');
      $bulan = $request->input('bulan');
      $hari = $request->input('hari');

      if($tahun && !$bulan){
        $stat = DB::select("SELECT operator.nama as nama_operator, count(id) as jumlah,YEAR(tanggal_pelayanan) as tahun FROM antrian_terlayani
        LEFT JOIN operator on operator.no_loket=antrian_terlayani.no_loket
        WHERE YEAR(tanggal_pelayanan) = ? GROUP BY operator.id_operator",[$tahun]);
        return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
      }else if($tahun && $bulan){
        $stat = DB::select("SELECT operator.nama as nama_operator, count(id) as jumlah,YEAR(tanggal_pelayanan) as tahun FROM antrian_terlayani
        LEFT JOIN operator on operator.no_loket=antrian_terlayani.no_loket
        WHERE YEAR(tanggal_pelayanan) = ? AND MONTH(tanggal_pelayanan) = ? GROUP BY operator.id_operator",[$tahun,$bulan]);
        return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
      }else{
        $stat = DB::select("SELECT operator.nama as nama_operator, count(id) as jumlah,YEAR(tanggal_pelayanan) as tahun FROM antrian_terlayani
        LEFT JOIN operator on operator.no_loket=antrian_terlayani.no_loket
        GROUP BY operator.id_operator");
        return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
      }
    }

    public function operator() {
      $stat = DB::select("SELECT id_operator,operator.nama as nama_operator,pelayanan.nama_pelayanan,loket.no_loket FROM operator
      INNER JOIN loket on operator.no_loket=loket.no_loket
      INNER JOIN pelayanan on pelayanan.id_pelayanan=loket.id_pelayanan");
      return response()->json(['status'=> 200, 'messages' => 'success', 'result' => $stat]);
    }

    public function loket() {
      $stat = DB::select("SELECT pelayanan.nama_pelayanan,loket.no_loket,count(antrian_terlayani.no_loket) as jumlah FROM antrian_terlayani
      RIGHT JOIN loket on loket.no_loket=antrian_terlayani.no_loket
      RIGHT JOIN pelayanan on pelayanan.id_pelayanan=loket.id_pelayanan
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
