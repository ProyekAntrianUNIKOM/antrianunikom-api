<?php
namespace App\Library;
class QueueHandler{
    private $antrian;
    function getAntrian(){
        return $this->antrian; 
    }         
    function setAntrian($antrian){
        $this->antrian = $antrian; 
    }

    public function __construct(){
        $this->antrian  = array();
    }

    public function tambah($data){
        array_push($this->antrian,$data);
    }

    public function ambil(){
        return array_shift($this->antrian);
    }

    public function hallo(){
        return "Testing";
    }

}

?>