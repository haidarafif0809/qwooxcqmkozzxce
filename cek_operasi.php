<?php 
include 'db.php';
include 'sanitasi.php';


$kelas_kamar = stringdoang($_POST['kelas_kamar']);
$operasi = stringdoang($_POST['operasi']);
$cito = stringdoang($_POST['cito']); 

$take = $db->query("SELECT id_sub_operasi FROM sub_operasi WHERE id_operasi = '$operasi' AND id_cito = '$cito' AND id_kelas_kamar = '$kelas_kamar'");
$give = mysqli_fetch_array($take);

echo $give['id_sub_operasi'];

 ?>