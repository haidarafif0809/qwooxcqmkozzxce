<?php
include_once 'db.php';
include_once 'sanitasi.php';

$nama_lengkap = stringdoang(urldecode($_GET['nama_lengkap']));
$tempat_lahir = stringdoang(urldecode($_GET['tempat_lahir']));
$umur = stringdoang(urldecode($_GET['umur']));
$alamat_sekarang = stringdoang(urldecode($_GET['alamat_sekarang']));
$no_telepon = angkadoang(urldecode($_GET['no_telepon'])); 
$penjamin = stringdoang(urldecode($_GET['penjamin']));
$no_rm = stringdoang(urldecode($_GET['no_rm']));


$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');




// UPDATE PASIEN NYA
 $update_pasien = "UPDATE pelanggan SET umur = '$umur',no_telp = '$no_telepon', alamat_sekarang = '$alamat_sekarang', penjamin = '$penjamin' , nama_pelanggan = '$nama_lengkap' , tempat_lahir = '$tempat_lahir' WHERE kode_pelanggan = '$no_rm'";
if ($db_pasien->query($update_pasien) === TRUE) 
  {
} 
else{
    echo "Error: " . $update_pasien . "<br>" . $db_pasien->error;
    } 
// UPDATE PASIEN 

?>

