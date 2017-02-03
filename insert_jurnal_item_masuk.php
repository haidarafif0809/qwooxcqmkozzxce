<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data penjualan berdasarkan trtansaksi yang sudah ada
$pilih_item_masuk = $db->query("SELECT * FROM item_masuk WHERE tanggal >= '2017-01-01'");
while ($data_masuk = mysqli_fetch_array($pilih_item_masuk)) { //START while ($data_masuk) {

  $no_faktur = $data_masuk['no_faktur'];
  $user = $data_masuk['user'];
  $tanggal_sekarang = $data_masuk['tanggal'];
  $jam_sekarang = $data_masuk['jam'];

$ambil_detail = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_item_masuk WHERE no_faktur = '$no_faktur'");
$data_detail = mysqli_fetch_array($ambil_detail);
$subtotal_detail = $data_detail['subtotal'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '$subtotal_detail', '0', 'Item Masuk', '$no_faktur','1', '$user')");

  //ITEM MASUK    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Masuk -', '$ambil_setting[item_masuk]', '0', '$subtotal_detail', 'Item Masuk', '$no_faktur','1', '$user')");



} //END while ($data_masuk) {

?>