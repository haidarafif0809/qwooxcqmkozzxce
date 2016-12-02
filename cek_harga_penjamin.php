<?php
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_POST['penjamin']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query2 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data2  = mysqli_fetch_array($query2);

$level_harga = $data2['harga'];

$query3 = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
$data  = mysqli_fetch_array($query3);

if ($level_harga == 'harga_1') {
	$harga = $data['harga_jual'];
}
elseif ($level_harga == 'harga_2') {
	$harga = $data['harga_jual2'];
}
elseif ($level_harga == 'harga_3') {
	$harga = $data['harga_jual3'];
}
elseif ($level_harga == 'harga_4') {
	$harga = $data['harga_jual5'];
}
elseif ($level_harga == 'harga_6') {
	$harga = $data['harga_jual6'];
}
elseif ($level_harga == 'harga_7') {
	$harga = $data['harga_jual7'];
}

if ($harga == '') {
$harga = '0';
}
else
{
$harga = $harga;
}
echo $harga;



?>