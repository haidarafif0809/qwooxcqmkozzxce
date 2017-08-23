<?php 
	include 'db.php';
	include 'sanitasi.php';

	$dari_tanggal = stringdoang($_GET['dari_tanggal']);
	$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

	$query_penjualan = $db->query("SELECT no_faktur, tanggal, jam FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
	while ($data_penjualan = mysqli_fetch_array($query_penjualan)) {

		$waktu_penjualan = $data_penjualan['tanggal']." ".$data_penjualan['jam'];


		$update_waktu_detail_penjualan = $db->query("UPDATE detail_penjualan SET waktu = '$waktu_penjualan' WHERE no_faktur = '$data_penjualan[no_faktur]'");
	}

	echo "SELESAI UPDATE WAKTU DETAIL PENJUALAN";
?>