<?php
include 'db.php';
include 'sanitasi.php';

$kd_pelanggan1 = stringdoang($_POST['kode_pelanggan1']);
$query2 = $db_pasien->query(" SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kd_pelanggan1'");
$data2  = mysqli_fetch_array($query2);
echo $kode_pelanggan = $data2['nama_pelanggan'];


?>