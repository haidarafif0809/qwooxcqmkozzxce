<?php 
include 'db.php';

$select = $db->query("SELECT harga_jual, kode_barang FROM barang WHERE berkaitan_dgn_stok = 'Jasa' ");
while($amb = mysqli_fetch_array($select))
{


$data_fee = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE kode_produk = '$amb[kode_barang]' AND nama_produk = '$amb[nama_barang]'");
$data = mysqli_fetch_array($data_fee);
$jumlah_uang = $jumlah_prosentase * $amb['harga_jual'] / 100;
$jumlah_prosentase = 0;

$update = $db->query("UPDATE fee_produk SET jumlah_uang = '$jumlah_uang', jumlah_prosentase = '$jumlah_prosentase' WHERE kode_produk = '$amb[kode_barang]' AND nama_produk = '$amb[nama_barang]'");

}


echo "selesai";
 ?>