<?php

namespace App\Http\Controllers;
use DateTime;
use App\Library\QueueHandler;
use SplQueue;
use Illuminate\Http\Request;

class AntrianController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        
    }


    public function ambilakhir()
    {
      $sekarang=date('d');
      $data = app('db')->select("select max(tanggal_antrian) as akhir from antrian");
      $jumlah = app('db')->table('antrian')->count();
      if($jumlah>0){
        $date = DateTime::createFromFormat("Y-m-d", $data[0]->akhir);
        if($sekarang==$date->format("d")){
          $counter_file = "counter.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
        }else{
          $counter_file = "counter.txt";
          $fp = fopen($counter_file,"w");
          fputs($fp,0);
          fclose($fp);
          $counter_file = "counter.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
        }
      }else{
        $counter_file = "counter.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,0);
        fclose($fp);
        $counter_file = "counter.txt";
        $counter = join('',file($counter_file));
        trim($counter);
        $counter+=1;
      }
      $tanggal = date('Y-m-d');
      $waktu   = date('H:i:s');
      $noantrian = sprintf("%03d",$counter);
      $hasil['status']=200;
      $hasil['message']='Success';
      $hasil['result']=$noantrian;
      return response()->json($hasil);
    }

    public function tambah(Request $request)
    {
        $tanggal = date('Y-m-d');
        $waktu   = date('H:i:s');
        $rfid = $request->input('no_rfid');
        $no_loket = $request->input('no_loket');
        $noantrian = $request->input('noantrian');
        $counter_file = "counter.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,(int)$noantrian);
        fclose($fp);  
        $insert = app('db')->insert("insert into antrian(no_antrian,no_rfid,no_loket,tanggal_antrian,waktu_antrian)
                                    values('$noantrian','$rfid','$no_loket','$tanggal','$waktu')");
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

    public function tambahbackup(Request $request)
    {
      //return $counter;
      $sekarang=date('d');
      $data = app('db')->select("select max(tanggal_antrian) as akhir from antrian");
      $jumlah = app('db')->table('antrian')->count();
      if($jumlah>0){
        $date = DateTime::createFromFormat("Y-m-d", $data[0]->akhir);
        if($sekarang==$date->format("d")){
          $counter_file = "counter.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
          $fp = fopen($counter_file,"w");
          fputs($fp,$counter);
          fclose($fp);
        }else{
          $counter_file = "counter.txt";
          $fp = fopen($counter_file,"w");
          fputs($fp,0);
          fclose($fp);
          $counter_file = "counter.txt";
          $counter = join('',file($counter_file));
          trim($counter);
          $counter+=1;
          $fp = fopen($counter_file,"w");
          fputs($fp,$counter);
          fclose($fp);
        }
      }else{
        $counter_file = "counter.txt";
        $fp = fopen($counter_file,"w");
        fputs($fp,0);
        fclose($fp);
        $counter_file = "counter.txt";
        $counter = join('',file($counter_file));
        trim($counter);
        $counter+=1;
        $fp = fopen($counter_file,"w");
        fputs($fp,$counter);
        fclose($fp);
      }
      $tanggal = date('Y-m-d');
      $waktu   = date('H:i:s');
      $noantrian = sprintf("%03d",$counter);
      $rfid = $request->input('no_rfid');
      $no_loket = $request->input('no_loket');
      $insert = app('db')->insert("insert into antrian(no_antrian,no_rfid,no_loket,tanggal_antrian,waktu_antrian)
                                  values('$noantrian','$rfid','$no_loket','$tanggal','$waktu')");
      if($insert){

        /* tulis dan buka koneksi ke printer */
        $p = printer_open("Canon iP2700 series");
        /*if($p)
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
          printer_draw_text($p, "No Antrian Anda:", 350, 80);

          $font = printer_create_font("Arial", 300, 80, PRINTER_FW_MEDIUM, false, false, false, 0);
          printer_select_font($p, $font);
          printer_draw_text($p, "$noantrian", 350, 160);

          $font = printer_create_font("Arial", 40, 30, PRINTER_FW_NORMAL, false, false, false, 0);
          printer_select_font($p, $font);
          printer_draw_text($p, "Waktu Antrian :", $var_magin_left, 500);
          printer_draw_text($p, date("Y/m/d H:i:s"),$var_magin_left,580);
          printer_draw_line($p, $var_magin_left, 630, 1500, 630);
          printer_draw_text($p, "\"Harap nomor antrian ini dibawa ke counter\"", $var_magin_left, 680);
          printer_draw_text($p, "Terimakasih Atas Kunjungan Anda", 100,750);

          printer_draw_text($p, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 800);

          printer_delete_font($font);

          printer_end_page($p);
          printer_end_doc($p);

          printer_start_doc($p);
          printer_start_page($p);
          printer_close($p);
        }
        */
        $hasil['status']=201;
        $hasil['message']='Antrian berhasil ditambahkan';
        $hasil['result']=$noantrian;
        return response()->json($hasil);
      }
      $this->antrian->tambah($counter);
      return $counter;
    }

    public function ambil()
    {
       //$antrian = new QueueHandler;
       //$antrian->tambah(12);
       //return $antrian->hallo();
       return $this->antrian->ambil();

    }

    public function add()
    {
       $this->antrian->tambah(5);
       
    }

    public function simpan(Request $request){
      $id_antrian = $request->input('id_antrian');
      $operator   = $request->input('operator');
      $loket      = $request->input('loket');
      $sekarang = app('db')->select("select * from antrian where id_antrian='$id_antrian'");
      $no_antrian= $sekarang[0]->no_antrian;
      $id_antrian = $sekarang[0]->id_antrian;
      $update = app('db')->update("update temp set no_antrian='$no_antrian',id_antrian='$id_antrian' where no_loket='$loket'");
      $query = app('db')->insert("insert into antrian_terlayani set id_antrian='$id_antrian',operator='$operator'");
      if($query){
        $update = app('db')->update("update antrian set status='1' where id_antrian='$id_antrian'");
        if($update){
          $data['status']=200; 
          $data['message']='success';
          $data['result']=$no_antrian;
          return response()->json($data);
        }else{
          return response()->json(['status'=>400,'message'=>'error 1','result'=>$update]);
        }
      }else{
        return response()->json(['status'=>400,'message'=>'error 2','result'=>$query]);
      }
    }

    public function ambil_antrian($id){
      $result = app('db')->select("select * from antrian where status='0' and no_loket='$id'");
      if($result){
        $no_antrian= $result[0]->no_antrian;
        $id_antrian = $result[0]->id_antrian;
        $data['status']=200;
        $data['message']='success';
        $data['result']=$result;
        return response()->json($data);
      }else{
        $data['status']=400;
        $data['message']='failed';
        $data['result']=[];
        return response()->json($data);
      }
    }
    
    public function loket($id)
    {

      $result = app('db')->select("select loket.no_loket,operator.nama as operator,loket.nama_loket
                                from loket inner join operator on loket.no_loket = operator.no_loket
                                where loket.id_pelayanan='$id'");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$result;
      return response()->json($data);

    }

    public function getAllTemp(){
      $result = app('db')->select("select * from temp");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$result;
      return response()->json($data);
    }

    public function getTempByid($id){
      $result = app('db')->select("select * from temp where no_loket='$id'");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$result;
      return response()->json($data);
    }

    public function button(Request $request)
    {
      $field1 = $request->input('field1');
      $field2 = $request->input('field2');
      $field3 = $request->input('field3');
      $field4 = $request->input('field4');
      $insert = app('db')->insert("insert into button_antrian set field1='$field1',
                      field2='$field2',field3='$field3',field4=$field4");
      $query = app('db')->select("select * from button_antrian");
      $data['status']=200;
      $data['message']='success';
      $data['result']=$query;
      $nomor=0;

    }
    //
}
