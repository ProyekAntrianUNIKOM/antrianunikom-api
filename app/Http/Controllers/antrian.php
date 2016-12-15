<?php 
class antrian
{
    public $antri; 
    public function __construct()
    {
        parent::__construct();
        $this->antri = array();
    }

    public function tambah($nomor)
    {
        $this->antri->push($nomor);
    }

    public function tampil()
    {
        print_f($nomor);
    }
}
?>