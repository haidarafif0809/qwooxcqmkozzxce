<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET
$session_id = session_id();
$no_reg = stringdoang($_POST['no_reg']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE session_id = '$session_id' AND no_reg = '$no_reg'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
