<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

$id = angkadoang($_POST['id']);
$diskon_nominal = angkadoang($_POST['diskon_nominal']);
$diskon_persen = angkadoang($_POST['diskon_persen']);
$tax = angkadoang($_POST['tax']);

$update_diskon = "UPDATE setting_diskon_tax SET diskon_nominal = '$diskon_nominal', diskon_persen = '$diskon_persen', tax = '$tax' WHERE id = '$id'";


		
		if ($db->query($update_diskon) === TRUE) {
		} 
		
		else {
		echo "Error: " . $update_diskon . "<br>" . $db->error;
		}
        


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>