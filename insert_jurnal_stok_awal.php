<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data stok awal berdasarkan trtansaksi yang sudah ada
$pilih_stok_awal = $db->query("SELECT * FROM stok_awal WHERE tanggal >= '2017-01-01' GROUP BY no_faktur");
while ($data_masuk = mysqli_fetch_array($pilih_stok_awal)) { //START while ($data_masuk) {

  $no_faktur = $data_masuk['no_faktur'];
  $user = $data_masuk['user'];
  $tanggal_sekarang = $data_masuk['tanggal'];
  $jam_sekarang = $data_masuk['jam'];

$ambil_stok = $db->query("SELECT SUM(total) AS total FROM stok_awal WHERE no_faktur = '$no_faktur'");
$data_stok = mysqli_fetch_array($ambil_stok);
$total_stok = $data_stok['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Awal -', '$ambil_setting[persediaan]', '$total_stok', '0', 'Stok Awal', '$no_faktur','1', '$user')");

  //Stok Awal   
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Awal -', '$ambil_setting[stok_awal]', '0', '$total_stok', 'Stok Awal', '$no_faktur','1', '$user')");



} //END while ($data_masuk) {

?>