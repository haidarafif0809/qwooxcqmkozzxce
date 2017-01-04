<?php
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);

$query = $db_pasien->query("DELETE FROM pelanggan WHERE id = '$id'");


if ($query == TRUE)
	
{
	echo "ok";
}
else
{
	echo "no";
}

?>