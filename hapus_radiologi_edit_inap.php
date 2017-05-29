<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_POST['kode_barang']);
$no_pemeriksaan = stringdoang($_POST['no_pemeriksaan']);
$no_reg = stringdoang($_POST['no_reg']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE kode_barang = '$kode_barang' AND no_reg = '$no_reg' AND no_pemeriksaan = '$no_pemeriksaan'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
