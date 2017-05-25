<?php
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);
$kode_jasa_lab = stringdoang($_POST['kode_jasa_lab']);
$pemeriksaan_keberapa = stringdoang($_POST['pemeriksaan_keberapa']);

//QUERY HAPUS DATA HEADER
$query_hapus_detail_header = $db->query("DELETE FROM tbs_aps_penjualan WHERE kode_jasa = '$kode_jasa_lab' AND no_reg = '$no_reg' AND no_periksa_lab_inap = '$pemeriksaan_keberapa'");

$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa_lab' AND no_reg = '$no_reg'");

//HAPUS TBS PENJUALAN
$query_hapus_tbs_jual = $db->query("DELETE FROM tbs_penjualan WHERE kode_barang = '$kode_jasa_lab' AND no_reg = '$no_reg' AND lab_ke_berapa = '$pemeriksaan_keberapa'");

$query_hapus_fee_jasa_lab = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_jasa_lab' AND no_reg = '$no_reg' ");
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
