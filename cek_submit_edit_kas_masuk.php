<?php 
include 'db.php';
include 'sanitasi.php';



$no_faktur = stringdoang($_POST['no_faktur']);

$select = $db->query("SELECT * FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur' ");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ada";
}
else{
	echo "kosong";
}

 ?>