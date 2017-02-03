<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_GET['kode_barang']);


$result = $db->query("SELECT * FROM jasa_lab WHERE kode_lab = '$kode_barang'");
$row = mysqli_fetch_array($result);
   
    echo json_encode($row);
    exit;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>