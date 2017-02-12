<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_faktur = stringdoang($_POST['no_faktur']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' AND session_id IS NULL");
 $datalab = mysqli_fetch_array($querylab);
 
echo$totallab = $datalab['total_penjualan'];



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
