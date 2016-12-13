<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);
 $total_akhir = angkadoang($_POST['total']);
 $diskon = angkadoang($_POST['potongan']);
 $pajak = angkadoang($_POST['tax']);
 $biaya_admin = angkadoang($_POST['biaya_adm']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '$no_reg'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];
 $total_tbs = ($total - $diskon) + ($biaya_admin + $pajak);

if ($total_akhir == $total_tbs) {
		echo "Oke";
	}
	else{
		echo "Zonk";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>