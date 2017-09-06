<?php 
include 'db.php';
include 'sanitasi.php';


//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $tempat_lahir = stringdoang(urldecode($_GET['tempat_lahir']));
  $umur = stringdoang(urldecode($_GET['umur']));
  $alamat_sekarang = stringdoang(urldecode($_GET['alamat_sekarang']));
  $alamat_ktp = stringdoang(urldecode($_GET['alamat_ktp']));
  $no_telepon = stringdoang(urldecode($_GET['no_telepon']));
  $status_kawin = stringdoang(urldecode($_GET['status_kawin']));
  $agama = stringdoang(urldecode($_GET['agama']));
  $penjamin = stringdoang(urldecode($_GET['penjamin']));
  $no_ktp = stringdoang(urldecode($_GET['no_ktp']));
  $no_rm = stringdoang(urldecode($_GET['no_rm']));
  $nama_lengkap = stringdoang(urldecode($_GET['nama_lengkap']));

// UPDATE PASIEN NYA
  $update_pasien = "UPDATE pelanggan SET umur = '$umur',no_telp = '$no_telepon', alamat_sekarang = '$alamat_sekarang', penjamin = '$penjamin' , nama_pelanggan = '$nama_lengkap' , tempat_lahir = '$tempat_lahir', alamat_ktp = '$alamat_ktp', no_ktp = '$no_ktp', status_kawin = '$status_kawin', agama = '$agama' WHERE kode_pelanggan = '$no_rm'";
  if ($db_pasien->query($update_pasien) === TRUE) {
  } 
  else {
    echo "Error: " . $update_pasien . "<br>" . $db_pasien->error;
  } 
// UPDATE PASIEN 

?>