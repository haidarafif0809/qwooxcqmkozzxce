<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$query_cek_tbs = $db->query("SELECT id_pemeriksaan,kode_barang FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND status_pasien = 'APS'");
$data_hasil = mysqli_num_rows($query_cek_tbs);
$data_id_hasil = mysqli_fetch_array($query_cek_tbs);
if ($data_hasil > 0){
  echo json_decode($data_id_hasil);
}

mysqli_close($db);
      
?>