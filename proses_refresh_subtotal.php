<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);

 if ($no_reg != '') {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg' AND lab IS NULL AND no_faktur IS NULL");
 $data = mysqli_fetch_array($query);

 $total = $data['total_penjualan'];



// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium' AND no_faktur IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];


echo$tt = $total + $totallab;

 }
 else
 {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND lab = 'Laboratorium' AND no_faktur IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];


echo$totallab;
 }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
