<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);

 if ($no_reg != '') {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
 $data = mysqli_fetch_array($query);

 $total = $data['total_penjualan'];


 $sql_ops = $db->query("SELECT SUM(harga_jual) AS total_ops FROM tbs_operasi WHERE no_reg = '$no_reg'");
 $data_ops = mysqli_fetch_array($sql_ops);

 $sum_radiologi = $db->query("SELECT SUM(harga) AS total_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1'");
 $data_sum = mysqli_fetch_array($sum_radiologi);


echo $subtotal = $total + $data_ops['total_ops'] + $data_sum['total_radiologi'];

 }
 else
 {

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND lab = 'Laboratorium' AND no_faktur IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];

  $sum_radiologi = $db->query("SELECT SUM(harga) AS total_radiologi FROM tbs_penjualan_radiologi WHERE session_id = '$session_id' AND status_periksa = '1' AND no_faktur IS NULL");
 $data_sum = mysqli_fetch_array($sum_radiologi);



echo $subtotal = $totallab + $data_sum['total_radiologi'];
 }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
