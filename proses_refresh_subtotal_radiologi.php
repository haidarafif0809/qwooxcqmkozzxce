<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);

 if ($no_reg != '') {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan_radiologi berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_radiologi WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
 $data = mysqli_fetch_array($query);

 $total = $data['total_penjualan'];



// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan_radiologi berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND no_faktur IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];

 $sql_ops = $db->query("SELECT SUM(harga_jual) AS total_ops FROM tbs_operasi WHERE no_reg = '$no_reg'");
$data_ops = mysqli_fetch_array($sql_ops);


echo$tt = $total + $totallab + $data_ops['total_ops'];

 }
 else
 {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan_radiologi berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_radiologi WHERE session_id = '$session_id' AND no_faktur IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];


echo$totallab;
 }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
