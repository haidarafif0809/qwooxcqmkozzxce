<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data stok awal berdasarkan trtansaksi yang sudah ada
$pilih_stok_awal = $db->query("SELECT * FROM detail_kas_masuk WHERE tanggal >= '2017-01-01'");
while ($data_kas = mysqli_fetch_array($pilih_stok_awal)) { //START while ($data_kas) {

  $no_faktur = $data_kas['no_faktur'];
  $user = $data_kas['user'];
  $tanggal_sekarang = $data_kas['tanggal'];
  $jam_sekarang = $data_kas['jam'];
 

      $pilih = $db->query("SELECT dk.ke_akun, da.nama_daftar_akun, jt.kode_akun_jurnal FROM detail_kas_masuk dk INNER JOIN daftar_akun da ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON dk.ke_akun = jt.kode_akun_jurnal");
      $ke_akun_select = mysqli_fetch_array($pilih);

      $pilih = $db->query("SELECT dk.dari_akun, da.nama_daftar_akun, jt.kode_akun_jurnal FROM detail_kas_masuk dk INNER JOIN daftar_akun da ON dk.dari_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON dk.dari_akun = jt.kode_akun_jurnal WHERE jt.kode_akun_jurnal = '$data_kas[dari_akun]'");
      $dari_akun_select = mysqli_fetch_array($pilih);


      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transaksi Kas Masuk ke $ke_akun_select[nama_daftar_akun]','$data_kas[ke_akun]', '$data_kas[jumlah]', '0', 'Kas Masuk', '$no_faktur','1', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transaksi Kas Masuk dari $dari_akun_select[nama_daftar_akun]','$data_kas[dari_akun]', '0', '$data_kas[jumlah]', 'Kas Masuk', '$no_faktur','1', '$user')");



} //END while ($data_kas) {

?>