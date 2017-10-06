<?php 
include 'db.php';
include 'sanitasi.php';


//DATA YANG DIBUTUHKAN DI PROSES UPDATE PASIEN REG RJ
  $kode_pelanggan = stringdoang(urldecode($_GET['kode_pelanggan']));

// SELECT PASIEN NYA
  $data_pelanggan = $db_pasien->query("SELECT tempat_lahir, tgl_lahir, alamat_sekarang, no_ktp, alamat_ktp, status_kawin, pendidikan_terakhir, agama, nama_suamiortu, pekerjaan_suamiortu, nama_penanggungjawab, hubungan_dengan_pasien, no_hp_penanggung, alamat_penanggung, alergi FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'")->fetch_array();

  echo json_encode($data_pelanggan);
// SELECT PASIEN 

?>