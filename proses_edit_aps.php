<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

	$no_rm = stringdoang(urlencode($_POST['no_rm']));
	$nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
	$jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
	$umur = stringdoang(urlencode($_POST['umur']));
	$gol_darah = stringdoang(urlencode($_POST['gol_darah']));
	$alamat = stringdoang(urlencode($_POST['alamat']));
	$no_telepon = stringdoang(urlencode($_POST['no_telepon']));
	$kondisi = stringdoang(urlencode($_POST['kondisi']));
	$alergi = stringdoang(urlencode($_POST['alergi']));
	$dokter = stringdoang(urlencode($_POST['dokter']));
	$petugas = $_SESSION['nama'];
	$periksa = stringdoang(urlencode($_POST['periksa']));
	$tanggal_lahir = stringdoang(urlencode(tanggal_mysql($_POST['tanggal_lahir'])));
	$agama = stringdoang(urlencode($_POST['agama']));

	//times sekarang
	$jam =  date("H:i:s");
	$tanggal_sekarang = date("Y-m-d ");
	$waktu = date("Y-m-d H:i:s");
	$bulan_php = date('m');
	$tahun_php = date('Y');


//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU UGD
  $data_reg_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '10' ")->fetch_array();

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?nama_pelanggan='.$nama_lengkap.'&tgl_lahir='.$tanggal_lahir.'&gol_darah='.$gol_darah.'&umur='.$umur.'&no_telp='.$no_telepon.'&alamat_sekarang='.$alamat.'&agama='.$agama.'&kode_pelanggan='.$no_rm;

 $file_get = file_get_contents($data_url);
//PROSES INPUT PASIEN KE DB ONLINE


// UPDATE REGISTRASI DATA 
$query_update_registrasi_aps = $db->query("UPDATE registrasi SET nama_pasien = '".urldecode($nama_lengkap)."', jenis_kelamin = '".urldecode($jenis_kelamin)."',
	umur_pasien = '".urldecode($umur)."', gol_darah = '".urldecode($gol_darah)."',
	alamat_pasien = '".urldecode($alamat)."', hp_pasien = '".urldecode($no_telepon)."',
	kondisi = '".urldecode($kondisi)."', alergi = '".urldecode($alergi)."', dokter = '".urldecode($dokter)."',dokter_pengirim = '".urldecode($dokter)."',
	aps_periksa = '".urldecode($periksa)."'  WHERE no_rm = '".urldecode($no_rm)."' ");
// UPDATE REGISTRASI DATA 



?>