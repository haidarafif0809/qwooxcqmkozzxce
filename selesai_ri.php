<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);
$id = stringdoang($_GET['id']);


$update = $db->query("UPDATE rekam_medik_inap SET status = 'Selesai' WHERE id = '$id' ");

    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekam_medik_inap.php">';

 ?>