delete_jenis_obat<?php
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_POST['id']);
$query = $db->query("DELETE FROM jenis WHERE id='$id'");

if ($query == TRUE)
	
{
	echo "ok";
}
else
{
	echo "no";
}

?>