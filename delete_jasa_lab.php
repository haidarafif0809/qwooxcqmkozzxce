<?php
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_POST['id']);

$query = $db->query("DELETE FROM jasa_lab WHERE id = '$id'");

if ($query == TRUE)
	
{
	echo "ok";
}


?>