<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);
 $total_akhir = angkadoang($_POST['total']);
 $diskon = angkadoang($_POST['potongan']);
 /*
 $pajak = angkadoang($_POST['tax']);*/

 $biaya_admin = angkadoang($_POST['biaya_adm']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];

 $sum_harga = $db->query("SELECT SUM(subtotal) AS harga_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur IS NULL");
 $data_radiologi= mysqli_fetch_array($sum_harga);
 


$total_tbs = ($total - $diskon) + $biaya_admin + $data_radiologi['harga_radiologi'];

if ($total_akhir == $total_tbs) {
		echo 1;
	}
	else{
		echo 0;
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
