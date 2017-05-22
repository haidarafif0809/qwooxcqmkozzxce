<?php session_start();

include 'db.php';
include 'sanitasi.php';

$no_reg = $_POST['no_reg'];
$no_faktur = $_POST['no_faktur'];
$total_akhir = angkadoang($_POST['total']);
$diskon = angkadoang($_POST['diskon_rupiah']);
$biaya_admin = angkadoang($_POST['biaya_adm']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
$query_jumlah_harga = $db->query("SELECT SUM(harga) AS subtotal FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg' AND no_faktur = '$no_faktur'");
$data_jumlah_harga = mysqli_fetch_array($query_jumlah_harga);
$subtotal = $data_jumlah_harga['subtotal'];
$total_tbs = ($subtotal - $diskon) + $biaya_admin;

	if ($total_akhir == $total_tbs) {
		echo 1;
	}
	else{
		echo 0;
	}

mysqli_close($db); 
        
?>