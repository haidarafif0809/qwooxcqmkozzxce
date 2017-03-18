<?php 
include 'db.php';
include 'sanitasi.php';


$id = angkadoang($_POST['id']);

$query = $db->query("DELETE FROM setup_hasil WHERE id = '$id'");

$query = $db->query("DELETE FROM setup_hasil WHERE sub_hasil_lab = '$id'");


 ?>