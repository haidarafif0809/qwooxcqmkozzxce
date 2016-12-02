<?php
include 'db.php';
include 'sanitasi.php';

$jumlah_barang = stringdoang($_POST['jumlah_barang']);
$penjamin = stringdoang($_POST['penjamin']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query2 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data2  = mysqli_fetch_array($query2);

$level_harga = $data2['harga'];

$query3 = $db->query("SELECT harga_1, harga_2, harga_3, harga_4, harga_5, harga_6, harga_7 FROM jasa_lab WHERE kode_lab = '$kode_barang'");
$data  = mysqli_fetch_array($query3);

if ($level_harga == 'harga_1') {
	$harga = $data['harga_1'];
}
elseif ($level_harga == 'harga_2') {
	$harga = $data['harga_2'];
}
elseif ($level_harga == 'harga_3') {
	$harga = $data['harga_3'];
}
elseif ($level_harga == 'harga_4') {
	$harga = $data['harga_4'];
}
elseif ($level_harga == 'harga_5') {
	$harga = $data['harga_5'];
}
elseif ($level_harga == 'harga_6') {
	$harga = $data['harga_6'];
}
elseif ($level_harga == 'harga_7') {
	$harga = $data['harga_7'];
}


if ($harga == '') {
echo $harga = '0';
}
else
{
echo $harga * $jumlah_barang;

}



?>