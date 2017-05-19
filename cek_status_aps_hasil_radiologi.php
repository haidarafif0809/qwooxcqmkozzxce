<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$query_cek_hasil_radiologi = $db->query("SELECT status_periksa FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '0'");
$data_hasil = mysqli_num_rows($query_cek_hasil_radiologi);
if($data_hasil > 0){
	echo 1;
}

 ?>