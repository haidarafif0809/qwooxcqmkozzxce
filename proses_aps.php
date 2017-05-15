<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

echo $token = stringdoang($_POST['token']);

// start data agar tetap masuk 
try {
	$db->begin_transaction();

	if ($token == ''){
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';  

	}
	else{


	$no_rm = stringdoang($_POST['no_rm']);
	$nama_lengkap = stringdoang($_POST['nama_lengkap']);
	$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
	$umur = stringdoang($_POST['umur']);
	$gol_darah = stringdoang($_POST['gol_darah']);
	$alamat = stringdoang($_POST['alamat']);
	$no_telepon = stringdoang($_POST['no_telepon']);
	$kondisi = stringdoang($_POST['kondisi']);
	$alergi = stringdoang($_POST['alergi']);
	$dokter = stringdoang($_POST['dokter']);
	$jenis_pasien = 'APS';
	$status = 'aps_masuk';
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

	$query_cek_pasien = $db->query("SELECT nama_pasien,no_rm FROM registrasi WHERE jenis_pasien = 'APS'  ORDER BY id DESC LIMIT 1 ");
	$data_nama_pasien = mysqli_fetch_array($query_cek_pasien);

		if ($data_nama_pasien['nama_pasien'] == $nama_lengkap AND $data_nama_pasien['no_rm'] == $no_rm){
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';
		}
		else{
		// START NO. REG PASIEN
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
	(no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,gol_darah,
	alamat_pasien,hp_pasien,kondisi,alergi,dokter_pengirim,tanggal,jam,
	jenis_pasien,status,petugas,aps_periksa) 
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_registrasi->bind_param("ssssssssssssssssi",$no_rm,$no_reg,
	$nama_lengkap,$jenis_kelamin, $umur, $gol_darah, $alamat, $no_telepon,
	$kondisi, $alergi,$dokter, $tanggal_sekarang,$jam,
	$jenis_pasien,$status, $petugas, $periksa);

$query_insert_registrasi->execute();

//INSERT PEMERIKSAAN
if($periksa == '1'){	
	$query_insert_data_periksa = "INSERT INTO pemeriksaan_laboratorium 
	(no_reg,no_rm,waktu,status,nama_pasien,status_pasien) VALUES 
	('$no_reg','$no_rm','$waktu','0','$nama_lengkap','APS')";
		if ($db->query($query_insert_data_periksa) === TRUE){

		}
		else{
			echo "Error: " . $query_insert_data_periksa . "<br>" . $db->error;
	    }
}

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

	} // biar gk double 
} // token

$db->commit();
}
catch (Exception $e){
	$db->rollback();
}
?>