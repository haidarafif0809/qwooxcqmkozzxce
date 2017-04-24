<?php
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

if ($no_reg != '') {
	$query_hitung_jumlah_harga = $db->query("SELECT SUM(harga) AS total_harga FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
	$data_jumlah_harga = mysqli_fetch_array($query_hitung_jumlah_harga);
	echo $total = $data_jumlah_harga['total_harga'];

}


mysqli_close($db); 

?>