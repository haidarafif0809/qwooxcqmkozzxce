<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET
$session_id = session_id();

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE session_id = '$session_id'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
