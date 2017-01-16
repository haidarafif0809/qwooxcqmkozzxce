<?php 
include 'db.php';
include 'sanitasi.php';

$pemeriksaan = stringdoang($_POST['pemeriksaan']);

$select = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE nama_pemeriksaan = '$pemeriksaan'");
$out = mysqli_fetch_array($select);
if ($out > 0)
{
	 echo 1;
}

?>