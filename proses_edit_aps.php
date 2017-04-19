<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

	$no_rm = stringdoang($_POST['no_rm']);
	$nama_lengkap = stringdoang($_POST['nama_lengkap']);
	$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
	$umur = stringdoang($_POST['umur']);
	$gol_darah = stringdoang($_POST['gol_darah']);
	$alamat = stringdoang($_POST['alamat']);
	$no_telepon = stringdoang($_POST['no_telepon']);
	$kondisi = stringdoang($_POST['kondisi']);
	$alergi = stringdoang($_POST['alergi']);
	$dokter = angkadoang($_POST['dokter']);
	$petugas = $_SESSION['nama'];
	$periksa = stringdoang($_POST['periksa']);
	$tanggal_lahir = angkadoang($_POST['tanggal_lahir']);
	$agama = angkadoang($_POST['agama']);

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

// UPDATE REGISTRASI NYA
$query_update_registrasi_aps = $db->query("UPDATE registrasi SET 
	nama_pasien = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin',
	umur_pasien = '$umur', gol_darah = '$gol_darah',
	alamat_pasien = '$alamat', hp_pasien = '$no_telepon',
	kondisi = '$kondisi', alergi = '$alergi', dokter = '$dokter',dokter_pengirim = '$dokter',
	aps_periksa = '$periksa'  WHERE no_rm = '$no_rm' ");



?>