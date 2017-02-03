<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$no_reg = stringdoang($_POST['no_reg']);

$query = $db->query("SELECT SUM(tax) AS tax FROM penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
$jumlah = mysqli_fetch_array($query);

$tax = $jumlah['tax'];

if ($tax > 0) {
	echo "1";
}
else
{
 	
}

mysqli_close($db); 
 ?>
