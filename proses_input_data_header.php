<?php session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();

$tanggal = date('Y-m-d');
$jam = date('H:i:s');

$id_pemeriksaan = stringdoang($_POST['id_periksa']);
$kode_jasa_lab = stringdoang($_POST['kode_jasa_lab']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$analis  = stringdoang($_POST['analis']);
$dokter = stringdoang($_POST['dokter']);
$nama_pasien = stringdoang($_POST['nama_pasien']);
$tipe_barang = stringdoang($_POST['tipe_barang']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$aps_periksa = stringdoang($_POST['aps_periksa']);

  //Hapus Jika id sama dengan yang sudah ada di TBS
$query_hapus = $db->query("DELETE FROM tbs_hasil_lab WHERE kode_barang = '$kode_jasa_lab'");

//Select Detail dari ID Headernya
$query_select_detail = $db->query("SELECT id,nama_pemeriksaan,
  kelompok_pemeriksaan,model_hitung,normal_lk,normal_pr,text_hasil,
  metode,normal_lk2,normal_pr2,text_reference,satuan_nilai_normal,
  sub_hasil_lab,nama_sub FROM setup_hasil WHERE id = 
  '$id_pemeriksaan' AND kategori_index = 'Header'");
while($data_query_select_detail = mysqli_fetch_array($query_select_detail)){

  //Ambil Nama Jasa
  $query_ambil_nama_jasa = $db->query("SELECT nama,harga_1 FROM jasa_lab WHERE id = '$data_query_select_detail[nama_pemeriksaan]'");
  while($data_nama_jasa = mysqli_fetch_array($query_ambil_nama_jasa)){
  $nama_jasa = $data_nama_jasa['nama'];
  $harga_jasa = $data_nama_jasa['harga_1'];

  //INSERT DATA DETAILNYA 
  /*$query_insert_tbs_hasil = $db->query("INSERT INTO tbs_hasil_lab
    (id_pemeriksaan, no_reg, no_rm, kode_barang, status_pasien,
    nilai_normal_lk,nilai_normal_pr,normal_lk2,normal_pr2,
    nama_pemeriksaan,model_hitung,satuan_nilai_normal,id_sub_header,
    id_setup_hasil,tanggal,jam,dokter,analis,harga) VALUES 
    ('$data_query_select_detail[nama_pemeriksaan]',
    '$no_reg','$no_rm','$kode_jasa_lab','APS',
    '$data_query_select_detail[normal_lk]',
    '$data_query_select_detail[normal_pr]',
    '$data_query_select_detail[normal_lk2]',
    '$data_query_select_detail[normal_pr2]',
    '$nama_jasa','$data_query_select_detail[model_hitung]',
    '$data_query_select_detail[satuan_nilai_normal]',
    '$data_query_select_detail[sub_hasil_lab]',
    '$data_query_select_detail[id]','$tanggal','$jam','$dokter',
    '$analis','$harga_jasa')");*/

    //INSERT TBS APS PENJUALAN
    $query_insert_tbs_aps_penjualan = $db->query("INSERT INTO tbs_aps_penjualan (no_reg,kode_jasa,nama_jasa,harga,dokter,
      analis,tanggal,jam) VALUES ('$no_reg','$kode_jasa_lab',
      '$nama_jasa','$harga_jasa','$dokter','$analis','$tanggal',
      '$jam')");
  }

}

?>