<?php 
include 'db.php';
include 'sanitasi.php';

$kode = stringdoang($_POST['bed2']);
$no_reg = stringdoang($_POST['no_reg']);
$ruangan = stringdoang($_POST['id_ruangan2']);

if ($ruangan != '-') {
	# code...
	$query_tbs_penjualan = $db->query("SELECT kode_barang,no_reg,ruangan FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_reg = '$no_reg' AND ruangan = '$ruangan' ");
	$jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);

	if ($jumlah_data_tbs_penjualan > 0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
else{
	$query_tbs_penjualan = $db->query("SELECT kode_barang,no_reg,ruangan FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_reg = '$no_reg'");
	$jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);

	if ($jumlah_data_tbs_penjualan > 0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}


 ?>