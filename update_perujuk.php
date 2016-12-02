<?php
require_once 'db.php';
include_once 'sanitasi.php';

$id = stringdoang($_POST['id']);
$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$no_telp = angkadoang($_POST['no_telp']);

$query = $db->prepare("UPDATE perujuk SET  nama = ? , alamat = ? , no_telp = ? WHERE id= ? ");
$query->bind_param("sssi",$nama,$alamat,$no_telp,$id);
$query->execute();

if ($query == TRUE)

{
	header('location:perujuk.php');
}


?>