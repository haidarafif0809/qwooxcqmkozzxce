<?php 

include 'db.php';

$id = $_POST['id'];

$query = $db->query("DELETE FROM detail_operasi WHERE id_detail_operasi = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>