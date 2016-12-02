<?php 

include 'db.php';

$id = $_POST['id'];

$query = $db->query("DELETE FROM tbs_detail_operasi WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>