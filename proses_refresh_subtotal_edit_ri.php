<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);
 $no_faktur = stringdoang($_POST['no_faktur']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur'");
 $data = mysqli_fetch_array($query);

 $total = $data['total_penjualan'];

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $querylab = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium' AND no_faktur = '$no_faktur' ");
 $datalab = mysqli_fetch_array($querylab);
 $totallab = $datalab['total_penjualan'];

 $sql = $db->query("SELECT SUM(td.harga_jual) AS total_ops FROM tbs_operasi td LEFT JOIN user u ON td.petugas_input = u.id LEFT JOIN operasi op ON td.operasi = op.id_operasi WHERE td.no_reg = '$no_reg'");
 $ops = mysqli_fetch_array($sql);
 $t_ops = $ops['total_ops'];


echo$tt = $total + $totallab + $t_ops;



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
