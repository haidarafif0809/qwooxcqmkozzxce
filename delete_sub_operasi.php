<?php 
include 'db.php';

$id = $_POST['id'];

$query_detail = $db->query("DELETE FROM detail_operasi WHERE id_sub_operasi = '$id'");
$query = $db->query("DELETE FROM sub_operasi WHERE id_sub_operasi = '$id'");

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