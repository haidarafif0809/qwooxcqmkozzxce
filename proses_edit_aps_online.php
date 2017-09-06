<?php 
include_once 'db.php';
include_once 'sanitasi.php';

$nama_pelanggan = stringdoang(urldecode($_GET['no_rm']));
$tgl_lahir = stringdoang(urldecode($_GET['no_rm']));
$gol_darah = stringdoang(urldecode($_GET['no_rm']));
$umur = stringdoang(urldecode($_GET['no_rm']));
$no_telp = stringdoang(urldecode($_GET['no_rm']));
$alamat_sekarang = stringdoang(urldecode($_GET['no_rm']));
$agama = stringdoang(urldecode($_GET['no_rm']));
$kode_pelanggan = stringdoang(urldecode($_GET['no_rm']));

	//times sekarang
	$jam =  date("H:i:s");
	$tanggal_sekarang = date("Y-m-d ");
	$waktu = date("Y-m-d H:i:s");
	$bulan_php = date('m');
	$tahun_php = date('Y');

// UPDATE PASIEN NYA
$query_update_pasien = "UPDATE pelanggan SET 
	nama_pelanggan = '$nama_lengkap', tgl_lahir = '$tanggal_lahir',
	gol_darah = '$gol_darah', umur = '$umur', no_telp = '$no_telepon', 
	alamat_sekarang = '$alamat', agama = '$agama' 
	WHERE kode_pelanggan = '$no_rm'";
	if ($db_pasien->query($query_update_pasien) === TRUE){
	} 
	else{
		echo "Error: " . $query_update_pasien . "<br>" . $db_pasien->error;
	}
?>