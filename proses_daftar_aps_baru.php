<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang($_POST['token']);

// start data agar tetap masuk 
try {
	$db->begin_transaction();

	if ($token == ''){
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';  

	}
	else{

	$petugas = $_SESSION['nama'];
	$no_rm_lama = stringdoang($_POST['no_rm_lama']);
	$nama_lengkap = stringdoang($_POST['nama_lengkap']);
	$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
	$tempat_lahir = stringdoang($_POST['tempat_lahir']);
	$tanggal_lahir = stringdoang(tanggal_mysql($_POST['tanggal_lahir']));
	$umur = stringdoang($_POST['umur']);
	$gol_darah = stringdoang($_POST['gol_darah']);
	$alamat = stringdoang($_POST['alamat']);
	$no_telepon = stringdoang($_POST['no_telepon']);
	$agama = stringdoang($_POST['agama']);
	$alergi = stringdoang($_POST['alergi']);
	$kondisi = stringdoang($_POST['kondisi']);
	$dokter = angkadoang($_POST['dokter']);
	$periksa = stringdoang($_POST['periksa']);

	$jam =  date("H:i:s");
	$tanggal_sekarang = date("Y-m-d");
	$waktu = date("Y-m-d H:i:s");
	$bulan_php = date('m');
	$tahun_php = date('Y');

	$query_cek_pasien = $db->query("SELECT nama_pasien,no_rm FROM registrasi WHERE jenis_pasien = 'APS'  ORDER BY id DESC LIMIT 1 ");
	$data_nama_pasien = mysqli_fetch_array($query_cek_pasien);

		if ($data_nama_pasien['nama_pasien'] == $nama_lengkap AND $data_nama_pasien['no_rm'] == $no_rm_lama){
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';
		}
		else{

		// START NO. RM PASIEN
		$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
		$no_ter = mysqli_fetch_array($ambil_rm);
		$no_rm = $no_ter['kode_pelanggan'] + 1;


		$tahun_terakhir = substr($tahun_php, 2);

		$bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM registrasi ORDER BY id DESC LIMIT 1");
		$v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
		$bulan_terakhir_reg = $v_bulan_terakhir['bulan'];
		//ambil nomor  dari penjualan terakhir
		$no_terakhir = $db->query("SELECT no_reg FROM registrasi ORDER BY id DESC LIMIT 1");
		 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
		$ambil_nomor = substr($v_no_terakhir['no_reg'],0,-8);

		if ($bulan_terakhir_reg != $bulan_php) {
		  # code...
		 $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;

		}

		else{

		$nomor = 1 + $ambil_nomor ;

		$no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


		}
		// AKHIR UNTUK NO REG

//Masukan pasien (data) APS Laboratorium/Radiologi ke registrasi
$query_insert_registrasi = $db->prepare("INSERT INTO registrasi 
	(no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,gol_darah,alamat_pasien,hp_pasien,
	kondisi,alergi,dokter_pengirim,tanggal,jam,
	jenis_pasien,status,petugas,aps_periksa) 
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

	$nama_lengkap = stringdoang($_POST['nama_lengkap']);
	$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
	$umur = stringdoang($_POST['umur']);
	$gol_darah = stringdoang($_POST['gol_darah']);
	$alamat = stringdoang($_POST['alamat']);
	$no_telepon = stringdoang($_POST['no_telepon']);
	$kondisi = stringdoang($_POST['kondisi']);
	$alergi = stringdoang($_POST['alergi']);
	$dokter = stringdoang($_POST['dokter']);
	$tanggal_sekarang = date("Y-m-d");
	$jam =  date("H:i:s");
	$jenis_pasien = 'APS';
	$status = 'aps_masuk';
	$petugas = $_SESSION['nama'];
	$periksa = stringdoang($_POST['periksa']);

$query_insert_registrasi->bind_param("ssssssssssssssssi",$no_rm,$no_reg,
	$nama_lengkap,$jenis_kelamin, $umur, $gol_darah, $alamat, $no_telepon,
	$kondisi, $alergi,$dokter, $tanggal_sekarang,$jam,
	$jenis_pasien,$status, $petugas, $periksa);

$query_insert_registrasi->execute();

if ($no_rm_lama != '' ){

$query_insert_rm_tidak_kosong = $db_pasien->prepare("INSERT INTO pelanggan 
	(kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,
	umur,alamat_sekarang,no_telp,jenis_kelamin,agama,alergi,gol_darah,
	tanggal,no_rm_lama)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_rm_tidak_kosong->bind_param("sssssssssssss",$no_rm,
	$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat,$no_telepon,
	$jenis_kelamin,$agama,$alergi,$gol_darah,$tanggal_sekarang,$no_rm_lama);

$query_insert_rm_tidak_kosong->execute();

$query_hapus_sesuai_rm_lama = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");

}
else{

$query_insert_rm_lama_kosong = $db_pasien->prepare("INSERT INTO pelanggan 
	(kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,
	umur,alamat_sekarang,no_telp,jenis_kelamin,agama,alergi,gol_darah,
	tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_rm_lama_kosong->bind_param("sssssssssssss",$no_rm,$nama_lengkap,
	$tempat_lahir,$tanggal_lahir,$umur,$alamat,$no_telepon,$jenis_kelamin,$agama,
	$alergi,$gol_darah,$tanggal_sekarang,$no_rm_lama);

$query_insert_rm_lama_kosong->execute();

}

 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';

		
	}
}
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

mysqli_close($db);

?>