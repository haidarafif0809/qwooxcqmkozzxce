<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET
$id = stringdoang($_POST['id']);
$no_reg = stringdoang($_POST['no_reg']);
$kode_barang = stringdoang($_POST['kode_barang']);



//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan WHERE id = '$id'");

$query2 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' AND kode_produk = '$kode_barang'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
