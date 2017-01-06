<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_GET['id']);
$no_reg = stringdoang($_GET['no_reg']);


$update = $db->query("UPDATE rekam_medik_ugd SET status = 'Selesai' WHERE id = '$id' AND no_reg = '$no_reg' ");

    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekam_medik_ugd.php">';

 ?>