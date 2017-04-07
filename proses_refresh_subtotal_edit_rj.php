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

  echo$total = $data['total_penjualan'];


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
