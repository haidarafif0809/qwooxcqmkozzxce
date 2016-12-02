<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);


$update = $db->query("UPDATE rekam_medik SET status = 'Selesai' WHERE no_reg = '$no_reg' ");

header('location:rekam_medik_raja.php');

 ?>