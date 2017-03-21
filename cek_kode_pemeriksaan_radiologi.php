<?php 	session_start();
include 'sanitasi.php';
include 'db.php';


$kode_pemeriksaan = stringdoang($_POST['kode_pemeriksaan']);

$query = $db->query("SELECT kode_pemeriksaan FROM pemeriksaan_radiologi WHERE kode_pemeriksaan = '$kode_pemeriksaan' ");
$data = mysqli_num_rows($query);

if ($data > 0) {
	echo "1";
}


 ?>