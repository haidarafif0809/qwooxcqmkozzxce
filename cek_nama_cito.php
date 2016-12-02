<?php 	session_start();
include 'sanitasi.php';
include 'db.php';


$nama = stringdoang($_POST['nama']);

$query = $db->query("SELECT nama FROM cito WHERE nama = '$nama' ");
$data = mysqli_num_rows($query);

if ($data > 0) {
	echo "1";
}


 ?>