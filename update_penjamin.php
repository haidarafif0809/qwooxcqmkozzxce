<?php 
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_POST['id']);
$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$no_telp = stringdoang($_POST['no_telp']);
$harga = stringdoang($_POST['level_harga']);
$layanan = $_POST['layanan'];
$jatuh_tempo = stringdoang($_POST['jatuh_tempo']);


$query = $db->query("UPDATE penjamin SET nama='$nama' ,alamat='$alamat' ,no_telp = '$no_telp' ,harga = '$harga', jatuh_tempo = '$jatuh_tempo', cakupan_layanan = '$layanan' WHERE id = '$id' ");

if ($query == TRUE)

{
	header('location:penjamin.php');
}

 ?>
