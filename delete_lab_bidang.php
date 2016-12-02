<?php 
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);

$query = $db->query("DELETE FROM bidang_lab WHERE id='$id'");


 ?>