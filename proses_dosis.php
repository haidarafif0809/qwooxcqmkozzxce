<?php 
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_POST['id']);
$dosis = stringdoang($_POST['dosis']);


$query = $db->query("UPDATE detail_penjualan SET dosis = '$dosis' WHERE id = '$id'  ");




	?>