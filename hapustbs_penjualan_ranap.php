<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET

$id = angkadoang($_POST['id']);
$kode_barang = stringdoang($_POST['kode_barang']);
$no_reg = stringdoang($_POST['no_reg']);

$ambil_waktu = $db->query("SELECT tanggal, jam FROM tbs_penjualan WHERE id = '$id'");
$data_waktu = mysqli_fetch_array($ambil_waktu);
$waktu = $data_waktu['tanggal']." ".$data_waktu['jam'];

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan WHERE id = '$id'");

$query2 = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_barang' AND no_reg = '$no_reg' AND waktu = '$waktu' ");



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
