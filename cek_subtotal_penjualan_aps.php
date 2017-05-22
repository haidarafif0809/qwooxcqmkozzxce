<?php
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $no_reg = stringdoang($_POST['no_reg']);
 $total_akhir = angkadoang($_POST['total']);
 $diskon = angkadoang($_POST['diskon_rupiah']);
 $biaya_admin = angkadoang($_POST['biaya_adm']);


 $query_sum_total_tbs = $db->query("SELECT SUM(harga) AS total_penjualan FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
 $data_sum_total_tbs = mysqli_fetch_array($query_sum_total_tbs);
 $total = $data_sum_total_tbs['total_penjualan'];

 $total_tbs = ($total - $diskon) + $biaya_admin;

if ($total_akhir == $total_tbs) {
		echo 1;
	}
	else{
		echo 0;
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
