<?php 
include_once 'db.php';
include_once 'sanitasi.php';

$nama_pelanggan = stringdoang(urldecode($_GET['nama_pelanggan']));
$tgl_lahir = stringdoang(urldecode($_GET['tgl_lahir']));
$gol_darah = stringdoang(urldecode($_GET['gol_darah']));
$umur = stringdoang(urldecode($_GET['umur']));
$no_telp = stringdoang(urldecode($_GET['no_telp']));
$alamat_sekarang = stringdoang(urldecode($_GET['alamat_sekarang']));
$agama = stringdoang(urldecode($_GET['agama']));
$kode_pelanggan = stringdoang(urldecode($_GET['kode_pelanggan']));

	//times sekarang
	$jam =  date("H:i:s");
	$tanggal_sekarang = date("Y-m-d ");
	$waktu = date("Y-m-d H:i:s");
	$bulan_php = date('m');
	$tahun_php = date('Y');

// UPDATE PASIEN NYA
$query_update_pasien = "UPDATE pelanggan SET 
	nama_pelanggan = '$nama_pelanggan', tgl_lahir = '$tgl_lahir',
	gol_darah = '$gol_darah', umur = '$umur', no_telp = '$no_telp', 
	alamat_sekarang = '$alamat_sekarang', agama = '$agama' 
	WHERE kode_pelanggan = '$kode_pelanggan'";
	if ($db_pasien->query($query_update_pasien) === TRUE){
	} 
	else{
		echo "Error: " . $query_update_pasien . "<br>" . $db_pasien->error;
	}
?>