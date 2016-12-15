<?php
namespace App\Library;
$antrian = array();

function tambah_antrian($data)
{
    $antrian->push($data);
}

function ambil_antrian()
{
    return $antrian->pop();
}
?>