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
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND no_reg = '$no_reg'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query2 = $db->query("SELECT harga_jual FROM tbs_operasi WHERE no_reg = '$no_reg'");
 $data2 = mysqli_fetch_array($query2);
 $total2 = $data2['harga_jual'];

 $total_sum = ($total + $total2);


$total_tbs = ($total_sum - $diskon) + $biaya_admin;

if ($total_akhir == $total_tbs) {
		echo "1";
	}
	else{
		echo "0";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
