<?php 
include 'db.php';

$level1 = 25;
$level2 = 37;

$gantis = $db->query("SELECT harga_beli, kode_barang FROM barangg ");
while($ganti = mysqli_fetch_array($gantis))
{

	$hargaBeli_barangg = $ganti['harga_beli'];
	$nilaiLevel1 = ($hargaBeli_barangg * $level1) / 100;
	$nilaiLevel2 = ($hargaBeli_barangg * $level2) / 100;
	$hargaJual1_barang = $hargaBeli_barangg + $nilaiLevel1;
	$hargaJual2_barang = $hargaBeli_barangg + $nilaiLevel2;

	$update = $db->query("UPDATE baranggg SET harga_jual = '$hargaJual1_barang', harga_jual2 = '$hargaJual2_barang' WHERE berkaitan_dgn_stok = 'Barang' AND harga_beli != 0 AND kode_barang = '$ganti[kode_barang]'");

	echo "UPDATE baranggg SET harga_jual = '$hargaJual1_barang', harga_jual2 = '$hargaJual2_barang' WHERE berkaitan_dgn_stok = 'Barang' AND harga_beli != 0 AND kode_barang = '$ganti[kode_barang]'";
} 


?>