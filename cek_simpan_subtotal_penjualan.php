<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
  $total = angkadoang($_POST['total']);
 $no_reg = stringdoang($_POST['no_reg']);
 $no_faktur = stringdoang($_POST['no_faktur']);

$biaya_admin = angkadoang($_POST['biaya_adm']);
$potongan = angkadoang($_POST['potongan']);
$tax = angkadoang($_POST['tax']);


		$subtotal_tampil = ($total + $potongan) - ($tax + $biaya_admin);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
 $data = mysqli_fetch_array($query);
 $totali = $data['total_penjualan'];

if ($subtotal_tampil == $totali) {
		echo "1";
	}
	else{
		echo "0";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>