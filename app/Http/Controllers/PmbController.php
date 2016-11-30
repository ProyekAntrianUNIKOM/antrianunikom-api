<?php

namespace App\Http\Controllers;
use DateTime;
use App\Library\QueueHandler;
use SplQueue;
use Illuminate\Http\Request;
use DB;

class PmbController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }


    public function cekhari()
    {
      $sekarang=date('d');
      $data = app('db')->select("select max(tanggal_antrian) as akhir from antrian_pmb");
      $jumlah = app('db')->table('antrian_pmb')->count();
      if($jumlah>0){
        $date = DateTime::createFromFormat("Y-m-d", $data[0]->akhir);
        if($sekarang!=$date->format("d")){
          $counter_file = "counterpmb.txt";
          $fp = fopen($counter_file,"w");
          fputs($fp,0);
          fclose($fp);
          $counter_file = "counterpmb.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
          DB::update("update temp_pmb set id_antrian='0',no_antrian='-'");
          DB::delete("delete from antrian_pmb");
        }
      }else{
        $counter_file = "counterpmb.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,0);
        fclose($fp);
        $counter_file = "counterpmb.txt";
        $counter = join('',file($counter_file));
        trim($counter);
        $counter+=1;
        DB::update("update temp_pmb set id_antrian='0',no_antrian='-'");
        DB::delete("delete from antrian_pmb");
      }
    }

    public function ambilantrian(){
      $sekarang=date('d');
      $data = app('db')->select("select max(tanggal_antrian) as akhir from antrian_pmb");
      $jumlah = app('db')->table('antrian_pmb')->count();
      //$counter=0;

      if($jumlah>0){
        $date = DateTime::createFromFormat("Y-m-d", $data[0]->akhir);
        if($sekarang==$date->format("d")){
          $counter_file = "counterpmb.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
        }else{
          $counter_file = "counterpmb.txt";
          $fp = fopen($counter_file,"w");
          fputs($fp,0);
          fclose($fp);
          $counter_file = "counterpmb.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
          DB::update("update temp_pmb set id_antrian='0',no_antrian='-'");
          DB::delete("delete from antrian_pmb");
        }
      }else{
        $counter_file = "counterpmb.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,0);
        fclose($fp);
        $counter_file = "counterpmb.txt";
        $counter = join('',file($counter_file));
        trim($counter);
        $counter+=1;
        DB::update("update temp_pmb set id_antrian='0',no_antrian='-'");
        DB::delete("delete from antrian_pmb");
      }

      $tanggal = date('Y-m-d');
      $waktu   = date('H:i:s');
      $noantrian = sprintf("%03d",$counter);
      $insert = app('db')->insert("insert into antrian_pmb(no_antrian,tanggal_antrian,waktu_antrian)values('$noantrian','$tanggal','$waktu')");
      if($insert) {
        $hasil['status']=200;
        $hasil['message']='Success';
        $hasil['result']=$noantrian;

        $counter_file = "counterpmb.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,(int)$noantrian);
        fclose($fp);
        return response()->json($hasil);
      } else {
        $hasil['status']=400;
        $hasil['message']='error';
        $hasil['result']=[];
        return response()->json($hasil);
      }
    }


    public function tambah(Request $request)
    {
        $tanggal = date('Y-m-d');
        $waktu   = date('H:i:s');
        $rfid = $request->input('no_rfid');
        $id_pelayanan = $request->input('id_pelayanan');
        $noantrian = $request->input('noantrian');
        $counter_file = "counter.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,(int)$noantrian);
        fclose($fp);
        $insert = app('db')->insert("insert into antrian(no_antrian,no_rfid,id_pelayanan,tanggal_antrian,waktu_antrian)
                                    values('$noantrian','$rfid','$id_pelayanan','$tanggal','$waktu')");
        if($insert)
        {
          /* tulis dan buka koneksi ke printer */
        //$p = printer_open("Canon iP2700 series");
        $p = false;
        if($p)
        {
          $var_magin_left=40;
          printer_set_option($p, PRINTER_MODE, "RAW");

          //then the width
          printer_set_option( $p,PRINTER_RESOLUTION_Y, 940);
          printer_start_doc($p);
          printer_start_page($p);
          printer_set_option($p, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM );
          printer_set_option($p,PRINTER_PAPER_WIDTH,15);
          printer_set_option($p,PRINTER_PAPER_LENGTH,50);

          $font = printer_create_font("Arial", 90, 50, PRINTER_FW_MEDIUM, false, false, false, 0);
          printer_select_font($p, $font);
          printer_draw_text($p, "ANTRIAN UNIKOM",300,0);
          //printer_draw_text($p, "",250,20);

          //$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
          //printer_select_pen($p, $pen);
          $font = printer_create_font("Arial", 80, 40, PRINTER_FW_MEDIUM, false, false, false, 0);
          printer_select_font($p, $font);
          //printer_draw_line($p, $var_magin_left, 50, 700, 50);
          printer_draw_text($p, "No Antrian Anda:", 340, 80);

          $font = printer_create_font("Arial", 300, 80, PRINTER_FW_MEDIUM, false, false, false, 0);
          printer_select_font($p, $font);
          printer_draw_text($p, "$noantrian", 420, 160);

          $font = printer_create_font("Arial", 40, 30, PRINTER_FW_NORMAL, false, false, false, 0);
          printer_select_font($p, $font);
          printer_draw_text($p, "Waktu Antrian :", $var_magin_left, 500);
          printer_draw_text($p, date("Y/m/d H:i:s"),$var_magin_left,580);
          printer_draw_line($p, $var_magin_left, 630, 1300, 630);
          printer_draw_text($p, "\"Harap nomor antrian ini dibawa ke counter\"", $var_magin_left, 680);
          printer_draw_text($p, "Terimakasih Atas Kunjungan Anda", 100,750);


          printer_delete_font($font);

          printer_end_page($p);
          printer_end_doc($p);

          //printer_start_doc($p);
          //printer_start_page($p);
          printer_close($p);


        }
          $hasil['status']=201;
          $hasil['message']='Antrian berhasil ditambahkan';
          $hasil['result']=$noantrian;
          return response()->json($hasil);
        }
        else
        {
          $hasil['status']=400;
          $hasil['message']='error';
          $hasil['result']=[];
          return response()->json($hasil);
        }
    }


    
}
