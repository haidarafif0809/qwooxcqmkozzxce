<?php 

include 'db.php';
include 'sanitasi.php';

    $nama_produk = stringdoang($_GET['nama_produk']);
 
    //ambil data barang

$result = $db->query("SELECT * FROM barang WHERE nama_barang = '$nama_produk'");
$row = mysqli_fetch_array($result);
   
    echo json_encode($row);
    exit;
 


     ?>