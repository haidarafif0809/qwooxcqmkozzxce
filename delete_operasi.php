<?php 
include 'db.php';

$id = $_POST['id'];

$query_detail = $db->query("DELETE FROM detail_operasi WHERE id_operasi = '$id'");

$query_sub = $db->query("DELETE FROM sub_operasi WHERE id_operasi = '$id'");

$query = "DELETE FROM operasi WHERE id_operasi = '$id'";

	if ($db->query($query) === TRUE) 
	  	{
	  	
		} 
	else 
	    {
	    echo "Error: " . $query . "<br>" . $db->error;
	    } 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>