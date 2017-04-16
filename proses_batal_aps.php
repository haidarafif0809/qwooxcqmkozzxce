<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['reg']);
$keterangan = stringdoang($_POST['keterangan']);

$query_update_status_batal = $db->query("UPDATE registrasi SET status = 'Batal APS' , keterangan = '$keterangan' WHERE no_reg = '$no_reg'");

$query_hapus_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");


 ?>