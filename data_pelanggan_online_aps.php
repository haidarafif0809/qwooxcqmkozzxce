<?php 
include 'db.php';
include 'sanitasi.php';


//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $kode_pelanggan = stringdoang(urldecode($_GET['kode_pelanggan']));

// SELECT PASIEN NYA
  $data_pelanggan = $db_pasien->query("SELECT tgl_lahir,alamat_sekarang,agama FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'")->fetch_array();

  echo json_encode($data_pelanggan);
// SELECT PASIEN 

?>