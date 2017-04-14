<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$no_reg = stringdoang($_POST['no_reg']);
$kode_jasa_lab = stringdoang($_POST['kode_jasa_lab']);

//QUERY HAPUS DATA HEADER
$query_hapus_detail_header = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa_lab' AND no_reg = '$no_reg'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
