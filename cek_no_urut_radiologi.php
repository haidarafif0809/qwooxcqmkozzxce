<?php 	session_start();
include 'sanitasi.php';
include 'db.php';


$no_urut = stringdoang($_POST['no_urut']);

$query = $db->query("SELECT no_urut FROM pemeriksaan_radiologi WHERE no_urut = '$no_urut' ");
$data = mysqli_num_rows($query);

if ($data > 0) {
	echo "1";
}


 ?>