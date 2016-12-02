<?php 

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];

//menghapus seluruh data yang ada pada tabel kas berdasarkan id
$query = $db->query("DELETE FROM bed WHERE id = '$id'");



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>