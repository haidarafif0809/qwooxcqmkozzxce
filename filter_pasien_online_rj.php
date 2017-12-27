<?php

include 'db.php';
include 'sanitasi.php';

//SELECT UNTUK MENGAMBIL SETTING URL U/ PENCARIAN PASIEN
$query_setting_registrasi_pasien = $db->query("SELECT url_cari_pasien FROM setting_registrasi_pasien WHERE id = '2' ");
$data_reg_pasien                 = mysqli_fetch_array($query_setting_registrasi_pasien);

$url                  = $data_reg_pasien['url_cari_pasien'];
$requestData          = $_REQUEST;
$search_value         = urlencode($requestData['search']['value']);
$start                = $requestData['start'];
$length               = $requestData['length'];
$draw                 = $requestData['draw'];
$no_rm_pasien         = urlencode(stringdoang($_POST['no_rm_pasien']));
$nama_lengkap_pasien  = urlencode(stringdoang($_POST['nama_lengkap_pasien']));
$alamat_pasien        = urlencode(stringdoang($_POST['alamat_pasien']));
$tanggal_lahir_pasien = urlencode(stringdoang($_POST['tanggal_lahir_pasien']));

$data_url = '' . $url . '?search_value=' . $search_value . '&start=' . $start . '&length=' . $length . '&draw=' . $draw . '&nama_lengkap_pasien=' . $nama_lengkap_pasien . '&alamat_pasien=' . $alamat_pasien . '&tanggal_lahir_pasien=' . $tanggal_lahir_pasien . '&no_rm_pasien=' . $no_rm_pasien;
//$data_url = 'https://www.google.co.id/';alamat_pasien
$file_get = file_get_contents($data_url);
echo $file_get;
