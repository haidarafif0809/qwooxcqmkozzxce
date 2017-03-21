<?php 
include 'db.php';
include_once 'sanitasi.php';

$kode = stringdoang($_POST['kode_pemeriksaan']);
$nama = stringdoang($_POST['nama_pemeriksaan']);
$harga_1 = angkadoang($_POST['harga_1']);
$harga_2 = angkadoang($_POST['harga_2']);
$harga_3 = angkadoang($_POST['harga_3']);
$harga_4 = angkadoang($_POST['harga_4']);
$harga_5 = angkadoang($_POST['harga_5']);
$harga_6 = angkadoang($_POST['harga_6']);
$harga_7 = angkadoang($_POST['harga_7']);
$kontras = angkadoang($_POST['kontras']);



    $perintah = $db->prepare("INSERT INTO pemeriksaan_radiologi (kode_pemeriksaan,nama_pemeriksaan,harga_1,harga_2,harga_3,harga_4,harga_5,harga_6,harga_7,kontras) VALUES (?,?,?,?,?,?,?,?,?,?)");

    $perintah->bind_param("ssiiiiiiii",
        $kode,$nama,$harga_1,$harga_2,$harga_3,$harga_4,$harga_5,$harga_6,$harga_7,$kontras);
  
    
    $perintah->execute();



if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}
    ?>
