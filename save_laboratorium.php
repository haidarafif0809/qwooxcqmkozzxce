<?php 
include 'db.php';
include_once 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$query_update_registrasi = $db->query("UPDATE registrasi SET status_lab = '2' WHERE no_reg = '$no_reg' ");

if ($query_update_registrasi == TRUE){
	echo '1';
}
else{
	echo '2';
}

 ?>
