<?php 
include 'db.php';
include 'sanitasi.php';

$kode_pemeriksaan = stringdoang($_POST['kode_pemeriksaan']);
$query = $db->query("DELETE FROM pemeriksaan_radiologi WHERE kode_pemeriksaan = '$kode_pemeriksaan'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>