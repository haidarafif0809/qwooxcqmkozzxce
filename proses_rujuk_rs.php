<?php 
include 'db.php';
include 'sanitasi.php';


$no_reg = stringdoang($_POST['reg']);
$keterangan = stringdoang($_POST['keterangan']);


$update = $db->query("UPDATE registrasi SET status = 'Rujuk Rumah Sakit', keterangan = '$keterangan' WHERE no_reg = '$no_reg'");



 ?>