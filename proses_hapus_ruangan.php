<?php 


include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);


$query = $db->query("DELETE FROM ruangan WHERE id = '$id'");

if ($query === TRUE) 
{

	echo 1;
  
} 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
