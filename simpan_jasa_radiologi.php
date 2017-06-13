<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$query_row = $db->query("SELECT no_pemeriksaan FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND no_pemeriksaan != '0' ORDER BY no_pemeriksaan DESC LIMIT 1");
$jumlah_row = mysqli_num_rows($query_row);
$data_row = mysqli_fetch_array($query_row);

if ($jumlah_row > 0) {
	$no_pemeriksaan = $data_row['no_pemeriksaan'] + 1;
}
else{
	$no_pemeriksaan = 1;
}

$query_update = $db->query("UPDATE tbs_penjualan_radiologi SET no_pemeriksaan = '$no_pemeriksaan' WHERE no_reg = '$no_reg' AND no_pemeriksaan = '0'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>