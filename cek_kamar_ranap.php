<?php 
include 'db.php';
include 'sanitasi.php';

$kode = stringdoang($_POST['bed2']);
$no_reg = stringdoang($_POST['no_reg']);



$select = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_reg = '$no_reg' ");
$my = mysqli_num_rows($select);

if ($my > 0)
{
	echo 1;
}
else
{
	echo 0;
}


 ?>