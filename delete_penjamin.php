<?php 
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);

$query = $db->query("DELETE FROM penjamin WHERE id='$id'");

if($query == TRUE)
{
	echo "ok";
}
else
{
	echo "no";
}

 ?>