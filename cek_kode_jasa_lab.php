<?php 	session_start();
include 'sanitasi.php';
include 'db.php';


$kode_jasa = stringdoang($_POST['kode_jasa']);

$query = $db->query("SELECT kode_lab FROM jasa_lab WHERE kode_lab = '$kode_jasa' ");
$data = mysqli_num_rows($query);

if ($data > 0) {
	echo "1";
}


 ?>