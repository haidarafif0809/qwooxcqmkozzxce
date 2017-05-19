<?php
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET
$kode_barang = stringdoang($_POST['kode_barang']);
$no_reg = stringdoang($_POST['no_reg']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query_tbs_radiologi = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE kode_barang = '$kode_barang' AND no_reg = '$no_reg'");

$query_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE kode_jasa = '$kode_barang' AND no_reg = '$no_reg'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
