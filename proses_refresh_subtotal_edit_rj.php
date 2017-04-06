<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);
 $no_faktur = stringdoang($_POST['no_faktur']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur' ");
 $data = mysqli_fetch_array($query);

$sum_harga = $db->query("SELECT SUM(subtotal) AS harga_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur = '$no_faktur'");
 $data_radiologi= mysqli_fetch_array($sum_harga);
 
 echo $subtotal = $data['total_penjualan'] + $data_radiologi['harga_radiologi'];



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
