<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$query =$db->query("UPDATE tbs_penjualan_radiologi SET status_simpan = '1' WHERE no_reg = '$no_reg'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>