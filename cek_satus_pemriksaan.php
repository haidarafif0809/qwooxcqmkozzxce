<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$select_tbs_radiologi = $db->query("SELECT COUNT(*) AS diperiksa FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1'");
$data = mysqli_fetch_array($select_tbs_radiologi);
echo $data['diperiksa'];
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>