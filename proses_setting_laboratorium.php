<?php
	// memasukan file db.php
include 'sanitasi.php';
include 'db.php';

$id = angkadoang($_POST['id']);
$nama = angkadoang($_POST['nama']);

$update_diskon = "UPDATE setting_laboratorium SET nama = '$nama' WHERE id = '$id'";

	if ($db->query($update_diskon) === TRUE)
	{

	} 
	else
	{
		echo "Error: " . $update_diskon . "<br>" . $db->error;
	}
        
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>