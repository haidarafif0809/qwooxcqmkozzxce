<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang(urlencode($_POST['token']));

// start data agar tetap masuk 
try {

	$db->begin_transaction();

	if ($token == ''){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_laboratorium.php">';

	}
	else{

	$petugas = $_SESSION['nama'];
	$no_rm_lama = stringdoang(urlencode($_POST['no_rm_lama']));
	$nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
	$jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
	$tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
	$tanggal_lahir = stringdoang(urlencode(tanggal_mysql($_POST['tanggal_lahir'])));
	$umur = stringdoang(urlencode($_POST['umur']));
	$gol_darah = stringdoang(urlencode($_POST['gol_darah']));
	$alamat = stringdoang(urlencode($_POST['alamat']));
	$no_telepon = stringdoang(urlencode($_POST['no_telepon']));
	$agama = stringdoang(urlencode($_POST['agama']));
	$alergi = stringdoang(urlencode($_POST['alergi']));
	$kondisi = stringdoang(urlencode($_POST['kondisi']));
	$periksa = stringdoang(urlencode($_POST['periksa']));

	$dokter_jg = stringdoang(urlencode($_POST['dokter']));
	$dokter_jg = explode("-", $dokter_jg);
	$id_dokter = $dokter_jg[0];
	$dokter = $dokter_jg[1];

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
			$no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;
		}
		else{
			$nomor = 1 + $ambil_nomor ;
			$no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;
		}
// AKHIR UNTUK NO REG

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU UGD
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '5' ");
  $data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&jenis_kelamin='.$jenis_kelamin.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&gol_darah='.$gol_darah.'&alamat='.$alamat.'&no_telepon='.$no_telepon.'&agama='.$agama.'&alergi='.$alergi.'&id_dokter='.$id_dokter.'&dokter='.$dokter;

  $file_get = file_get_contents($data_url);

//ambil no rm dari DB
  $no_rm = $file_get;

//Masukan pasien (data) APS Laboratorium/Radiologi ke registrasi
		$query_insert_registrasi = $db->prepare("INSERT INTO registrasi (no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,gol_darah,alamat_pasien,hp_pasien,kondisi,alergi,dokter_pengirim,tanggal,jam,jenis_pasien,status,petugas,aps_periksa,id_dokter) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

			$jenis_pasien = 'APS';
			$status = 'aps_masuk';

		$query_insert_registrasi->bind_param("ssssssssssssssssis",urldecode($no_rm),urldecode($no_reg),urldecode($nama_lengkap),urldecode($jenis_kelamin), urldecode($umur), urldecode($gol_darah), urldecode($alamat), urldecode($no_telepon),urldecode($kondisi), urldecode($alergi),urldecode($dokter), urldecode($tanggal_sekarang),urldecode($jam),$jenis_pasien,$status, urldecode($petugas), urldecode($periksa),urldecode($id_dokter));

		$query_insert_registrasi->execute();

//INSERT PEMERIKSAAN
		if($periksa == '1'){	
			$query_insert_data_periksa = "INSERT INTO pemeriksaan_laboratorium (no_reg,no_rm,waktu,status,nama_pasien,status_pasien) VALUES ('".urldecode($no_reg)."','".urldecode($no_rm)."','$waktu','0','".urldecode($nama_lengkap)."','APS')";
				if ($db->query($query_insert_data_periksa) === TRUE){
				}
				else{
					echo "Error: " . $query_insert_data_periksa . "<br>" . $db->error;
			    }
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