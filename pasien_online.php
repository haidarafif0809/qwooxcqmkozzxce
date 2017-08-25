<?php 
include 'db.php';

//SELECT UNTUK MENGAMBIL SETTING URL U/ PENCARIAN PASIEN
$query_setting_registrasi_pasien = $db->query("SELECT url_cari_pasien FROM setting_registrasi_pasien ");
$data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

$url = $data_reg_pasien['url_cari_pasien'];
$requestData= $_REQUEST;
$search_value = urlencode($requestData['search']['value']);
$start = $requestData['start'];
$length = $requestData['length'];
$draw = $requestData['draw'];

$data_url = ''.$url.'?search_value='.$search_value.'&start='.$start.'&length='.$length.'&draw='.$draw.'';
//$data_url = 'https://www.google.co.id/';
$file_get = file_get_contents($data_url);
echo $file_get;
?>