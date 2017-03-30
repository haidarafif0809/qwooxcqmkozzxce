<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$hasil_pemeriksaan = $db->query("SELECT hasil_pemeriksaan FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND hasil_pemeriksaan IS NULL");
$out = mysqli_num_rows($hasil_pemeriksaan);
if($out > 0){
	echo 1;
}

?>