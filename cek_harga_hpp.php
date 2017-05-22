<?php 

include 'db.php';
include 'sanitasi.php';

$harga_baru =  stringdoang($_POST['harga_baru']);
$kode_barang =  stringdoang($_POST['kode_barang']);

$query_harga_jual = $db->query("SELECT harga_jual FROM barang WHERE kode_barang = '$kode_barang'");
$data_harga_jual = mysqli_fetch_array($query_harga_jual);

echo $hasil_harga = $data_harga_jual['harga_jual'] - $harga_baru;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);

?>