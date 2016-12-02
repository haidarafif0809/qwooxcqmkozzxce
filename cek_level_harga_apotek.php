<?php 
include 'sanitasi.php';
include 'db.php';

$level_harga = stringdoang($_POST['level_harga']);
$kode_barang = stringdoang($_POST['kode_barang']);

$a = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang' ");
$data = mysqli_fetch_array($a);

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
	 $harga = $data['harga_jual4'];
}
elseif ($level_harga == 'harga_5') {
	 $harga = $data['harga_jual5'];
}
elseif ($level_harga == 'harga_6') {
	 $harga = $data['harga_jual6'];
}
elseif ($level_harga == 'harga_7') {
	 $harga = $data['harga_jual7'];
}
echo $harga;


 ?>