<?php 
include 'db.php';
include 'sanitasi.php';
//NOTE FILE INI BELUM BERGUNA , JADI TIDAK USAH DI REVIEW DULU

$no_reg = stringdoang($_GET['no_reg']);

$query_cek_tbs = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND status_pasien = 'APS'");

$arr = array();
while($data_id_hasil = mysqli_fetch_array($query_cek_tbs)){

$temp = array(
		"id_pemeriksaan" => $data_id_hasil['id_pemeriksaan']
		);

		array_push($arr, $temp);
}

	//echo json_encode($arr);
	$data = json_encode($arr);

echo '{ "id": "'.$data.'"}';

      
?>