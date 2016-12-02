<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);

$seleced = $db->query("SELECT kode_barang FROM barang WHERE nama_barang = '$nama'");
$dede = mysqli_fetch_array($seleced);
$kode = $dede['kode_barang'];

    $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode'");
    $ambil_sisa = mysqli_fetch_array($select);


echo $sisa_barang =$ambil_sisa['jumlah_barang'];

 ?>