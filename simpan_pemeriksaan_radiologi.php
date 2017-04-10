<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);
$dokter_radiologi = stringdoang($_POST['dokter_radiologi']);

$query =$db->query("UPDATE tbs_penjualan_radiologi SET status_simpan = '1', dokter_periksa = '$dokter_radiologi' WHERE no_reg = '$no_reg'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>