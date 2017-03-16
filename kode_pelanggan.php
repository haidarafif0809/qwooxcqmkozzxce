<?php
include 'db.php';
include 'sanitasi.php';

$nama_pelanggan = stringdoang($_POST['nama_pelanggan']);
$query2 = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE nama_pelanggan = '$nama_pelanggan'");
$data2  = mysqli_fetch_array($query2);
echo $kode_pelanggan = $data2['kode_pelanggan'];


?>