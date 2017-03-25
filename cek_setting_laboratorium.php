<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);

$cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
$get = mysqli_fetch_array($cek_setting);
$hasil = $get['nama'];
if($hasil == 1){

	$cek_jasa_lab_tbs = $db->query("SELECT no_reg,lab FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
	$show_jasa = mysqli_num_rows($cek_jasa_lab_tbs);
	if($show_jasa > 0){

		$cek_hasil_lab = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg'");
		$get_hasil = mysqli_num_rows($cek_hasil_lab);
		if($get_hasil > 0)
		{

		}else{

			$cek_tbs_hasil_lab = $db->query("SELECT hasil_pemeriksaan,no_reg FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
			$show = mysqli_num_rows($cek_tbs_hasil_lab);

			if($show >= 0){
			echo 1;
			}
			else{
			echo 0;
			}
		}

	}
}
 ?>