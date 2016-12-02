<?php 
include 'db.php';
include 'sanitasi.php';



$session_id = stringdoang($_POST['session_id']);

$select = $db->query("SELECT * FROM tbs_kas_keluar WHERE session_id = '$session_id' ");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ada";
}
else{
	echo "kosong";
}

 ?>