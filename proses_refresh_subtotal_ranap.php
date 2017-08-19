<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $no_reg = stringdoang($_POST['no_reg']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg'  AND no_faktur IS NULL");
 $data = mysqli_fetch_array($query);

 $total = $data['total_penjualan'];


 $sql = $db->query("SELECT SUM(td.harga_jual) AS total_ops FROM tbs_operasi td LEFT JOIN user u ON td.petugas_input = u.id LEFT JOIN operasi op ON td.operasi = op.id_operasi WHERE td.no_reg = '$no_reg'");
 $ops = mysqli_fetch_array($sql);
 $t_ops = $ops['total_ops'];

$query_radiologi = $db->query("SELECT SUM(subtotal) AS jumlah FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND radiologi = 'Radiologi' AND (no_faktur IS NULL OR no_faktur = '')");
$data_hasil_radiologi = mysqli_fetch_array($query_radiologi);
$jumlah_radiologi = $data_hasil_radiologi['jumlah'];

echo $tt = $total + $t_ops + $jumlah_radiologi;



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>
