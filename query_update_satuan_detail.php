<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$select_barang = $db->query("SELECT kode_barang, satuan FROM barang WHERE berkaitan_dgn_stok = 'Barang'");
while($data_barang = mysqli_fethc_array($select_barang)){

	//Detail Penjualan
	$update_penjualan = $db->query("UPDATE detail_penjualan SET satuan = '$data_barang[satuan]' 
		WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

	//Detail Pembelian
	$update_pembelian = $db->query("UPDATE detail_pembelian SET satuan = '$data_barang[satuan]' 
		WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

	//Detail Item Keluar
	$update_item_keluar = $db->query("UPDATE detail_item_keluar SET satuan = '$data_barang[satuan]' 
		WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

	//Detail Item Masuk
	$update_item_masuk = $db->query("UPDATE detail_item_masuk SET satuan = '$data_barang[satuan]' 
		WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

	//Detail Retur Penjualan
	$update_retur_penjualan = $db->query("UPDATE detail_retur_penjualan SET satuan = '$data_barang[satuan]' WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

	//Detail Retur Pembelian
	$update_retur_pembelian = $db->query("UPDATE detail_retur_pembelian SET satuan = '$data_barang[satuan]' WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

}


?>