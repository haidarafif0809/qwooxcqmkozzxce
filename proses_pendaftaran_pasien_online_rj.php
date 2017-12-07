<?php

include 'db.php';
include 'sanitasi.php';

//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
$no_rm_lama             = stringdoang(urldecode($_GET['no_rm_lama']));
$nama_lengkap           = stringdoang(urldecode($_GET['nama_lengkap']));
$no_ktp                 = stringdoang(urldecode($_GET['no_ktp']));
$tempat_lahir           = stringdoang(urldecode($_GET['tempat_lahir']));
$tanggal_lahir          = stringdoang(urldecode($_GET['tanggal_lahir']));
$tanggal_lahir          = tanggal_mysql($tanggal_lahir);
$umur                   = stringdoang(urldecode($_GET['umur']));
$alamat_sekarang        = stringdoang(urldecode($_GET['alamat_sekarang']));
$alamat_ktp             = stringdoang(urldecode($_GET['alamat_ktp']));
$no_telepon             = stringdoang(urldecode($_GET['no_telepon']));
$nama_suamiortu         = stringdoang(urldecode($_GET['nama_suamiortu']));
$pekerjaan_pasien       = stringdoang(urldecode($_GET['pekerjaan_pasien']));
$nama_penanggungjawab   = stringdoang(urldecode($_GET['nama_penanggungjawab']));
$hubungan_dengan_pasien = stringdoang(urldecode($_GET['hubungan_dengan_pasien']));
$no_hp_penanggung       = stringdoang(urldecode($_GET['no_hp_penanggung']));
$alamat_penanggung      = stringdoang(urldecode($_GET['alamat_penanggung']));
$jenis_kelamin          = stringdoang(urldecode($_GET['jenis_kelamin']));
$status_kawin           = stringdoang(urldecode($_GET['status_kawin']));
$pendidikan_terakhir    = stringdoang(urldecode($_GET['pendidikan_terakhir']));
$agama                  = stringdoang(urldecode($_GET['agama']));
$penjamin               = stringdoang(urldecode($_GET['penjamin']));
if ($penjamin == '') {
    $penjamin = 'PERSONAL';
}

$gol_darah = stringdoang(urldecode($_GET['gol_darah']));
$poli      = stringdoang(urldecode($_GET['poli']));
$dokter    = stringdoang(urldecode($_GET['dokter']));

$kondisi          = stringdoang(urldecode($_GET['kondisi']));
$rujukan          = stringdoang(urldecode($_GET['rujukan']));
$sistole_distole  = stringdoang(urldecode($_GET['sistole_distole']));
$respiratory_rate = stringdoang(urldecode($_GET['respiratory_rate']));
$suhu             = stringdoang(urldecode($_GET['suhu']));
$nadi             = stringdoang(urldecode($_GET['nadi']));
$berat_badan      = stringdoang(urldecode($_GET['berat_badan']));
$tinggi_badan     = stringdoang(urldecode($_GET['tinggi_badan']));
$alergi           = stringdoang(urldecode($_GET['alergi']));
$no_kk            = stringdoang(urldecode($_GET['no_kk']));
$nama_kk          = stringdoang(urldecode($_GET['nama_kk']));
$token            = stringdoang(urldecode($_GET['token']));

$perusahaan      = $db->query("SELECT nama_perusahaan FROM perusahaan LIMIT 1")->fetch_array();
$kode_klinik_reg = $db->query("SELECT kode_klinik FROM kode_klinik_reg LIMIT 1 ")->fetch_array();
$query_pelanggan = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE (kode_pelanggan != '0' OR kode_pelanggan IS NULL OR kode_pelanggan != '') AND kode_klinik =  '" . $kode_klinik_reg["kode_klinik"] . "' ORDER BY id DESC LIMIT 1 ")->fetch_array();

$angka_no_rm = str_replace($kode_klinik_reg['kode_klinik'] . '-', "", $query_pelanggan['kode_pelanggan']);
$no_rm       = $angka_no_rm + 1;
echo $no_rm  = $kode_klinik_reg['kode_klinik'] . '-' . $no_rm;
//JIKA ADA MIGRASI PASIEN
if ($no_rm_lama != '') {
    $no_rm_lama   = stringdoang(urldecode($_GET['no_rm_lama']));
    $hapus_pasien = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");
} else {
    $no_rm_lama = "";
}

//INSERT DATA PASIEN BARU
$query_insert_pasien = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama,kode_klinik,daftar_awal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_pasien->bind_param("ssssssssssssssssssssssssssss", $alergi, $no_kk, $nama_kk, $no_rm, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $umur, $alamat_sekarang, $alamat_ktp, $no_telepon, $no_ktp, $nama_suamiortu, $pekerjaan_pasien, $nama_penanggungjawab, $hubungan_dengan_pasien, $alamat_penanggung, $no_hp_penanggung, $jenis_kelamin, $pendidikan_terakhir, $status_kawin, $agama, $penjamin, $gol_darah, $tanggal_sekarang, $no_rm_lama, $kode_klinik_reg['kode_klinik'], $perusahaan['nama_perusahaan']);

$query_insert_pasien->execute();
