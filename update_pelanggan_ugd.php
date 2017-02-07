<?php 

include 'db.php';
include 'sanitasi.php';

    $no_rm = stringdoang($_GET['no_rm']);
 
    //ambil data barang

$result = $db_pasien->query("SELECT * FROM pelanggan WHERE kode_pelanggan = '$no_rm' ");
$row = mysqli_fetch_array($result);

$cek = $db->query("SELECT harga FROM penjamin WHERE nama = '$row[penjamin]'");
$data = mysqli_fetch_array($cek);
$harga_level = $data['harga'];

$row['level_harga'] = $harga_level;


    echo json_encode($row);
    exit;

     ?>