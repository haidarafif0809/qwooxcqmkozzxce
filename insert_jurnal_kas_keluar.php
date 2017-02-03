<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data stok awal berdasarkan trtansaksi yang sudah ada
$pilih_stok_awal = $db->query("SELECT * FROM detail_kas_keluar WHERE tanggal >= '2017-01-01'");
while ($data_kas = mysqli_fetch_array($pilih_stok_awal)) { //START while ($data_kas) {

  $no_faktur = $data_kas['no_faktur'];
  $user = $data_kas['user'];
  $tanggal_sekarang = $data_kas['tanggal'];
  $jam_sekarang = $data_kas['jam'];
 

	  $pilih = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.dari_akun FROM daftar_akun da INNER JOIN detail_kas_keluar dk ON dk.dari_akun = da.kode_daftar_akun");
      $dari_akun_select = mysqli_fetch_array($pilih);

      $select = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.ke_akun FROM daftar_akun da INNER JOIN detail_kas_keluar dk ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON jt.kode_akun_jurnal = da.kode_daftar_akun WHERE jt.kode_akun_jurnal = '$data_kas[ke_akun]'");
      $ke_akun_select = mysqli_fetch_array($select);

      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transaksi Kas Keluar dari $dari_akun_select[nama_daftar_akun]','$data_kas[dari_akun]', '0', '$data_kas[jumlah]', 'Kas Keluar', '$no_faktur','1', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transaksi Kas Keluar ke $ke_akun_select[nama_daftar_akun]','$data_kas[ke_akun]', '$data_kas[jumlah]', '0', 'Kas Keluar', '$no_faktur','1', '$user')");



} //END while ($data_kas) {

?>