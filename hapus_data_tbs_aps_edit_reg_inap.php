<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);
$kode_jasa = stringdoang($_POST['kode_jasa']);
$pemeriksaan_keberapa = stringdoang($_POST['pemeriksaan_keberapa']);
$id = stringdoang($_POST['id']);

//QUERY HAPUS TBS 
$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_aps_penjualan WHERE kode_jasa = '$kode_jasa' AND no_reg = '$no_reg' AND id = '$id' AND no_periksa_lab_inap = '$pemeriksaan_keberapa'");

//$query_hapus_tbs_penjualan = $db->query("DELETE FROM tbs_penjualan WHERE kode_barang = '$kode_jasa' AND no_reg = '$no_reg'");

$query_hapus_tbs_hasil_lab = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa' AND no_reg = '$no_reg'");

$query_hapus_fee_jasa_lab = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_jasa' AND no_reg = '$no_reg' ");

if($query_hapus_tbs_hasil == TRUE){
	echo 1;
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
