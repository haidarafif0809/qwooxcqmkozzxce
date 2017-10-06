<?php 
include 'db.php';
include 'sanitasi.php';


//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $kode_pelanggan = stringdoang(urldecode($_GET['kode_pelanggan']));



// SELECT PASIEN NYA
  $data_pelanggan = $db_pasien->query("SELECT tempat_lahir,tgl_lahir,umur,gol_darah,alamat_sekarang,no_telp,no_kk,nama_kk,no_ktp,alamat_ktp,status_kawin,pendidikan_terakhir,agama,nama_suamiortu,alamat_penanggung,pekerjaan_suamiortu FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'")->fetch_array();

  echo json_encode($data_pelanggan);
// SELECT PASIEN 

?>