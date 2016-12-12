<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $subtotal_tampil = angkadoang($_POST['total2']);



// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '' AND lab = 'Laboratorium' AND session_id IS NOT NULL ");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];

if ($subtotal_tampil != $total) {
		echo "2";
	}
	else{
		echo "1";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>