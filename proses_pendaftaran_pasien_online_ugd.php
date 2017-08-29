<?php 
include 'db.php';
include 'sanitasi.php';

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU RJ
$query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '1' ");
$data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

$url = $data_reg_pasien['url_data_pasien'];

//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $no_rm_lama = stringdoang(urldecode($_GET['no_rm_lama']));
  $nama_lengkap = stringdoang(urldecode($_GET['nama_lengkap']));
  $no_ktp = stringdoang(urldecode($_GET['no_ktp']));
  $tempat_lahir = stringdoang(urldecode($_GET['tempat_lahir']));
  $tanggal_lahir = stringdoang(urldecode($_GET['tanggal_lahir']));
  $tanggal_lahir = tanggal_mysql($tanggal_lahir);
  $umur = stringdoang(urldecode($_GET['umur']));
  $alamat_sekarang = stringdoang(urldecode($_GET['alamat_sekarang']));
  $alamat_ktp = stringdoang(urldecode($_GET['alamat_ktp']));
  $no_telepon = angkadoang(urldecode($_GET['no_telepon']));
  $nama_suamiortu = stringdoang(urldecode($_GET['nama_suamiortu']));
  $pekerjaan_pasien = stringdoang(urldecode($_GET['pekerjaan_pasien']));
  $jenis_kelamin = stringdoang(urldecode($_GET['jenis_kelamin']));
  $status_kawin = stringdoang(urldecode($_GET['status_kawin']));
  $pendidikan_terakhir = stringdoang(urldecode($_GET['pendidikan_terakhir']));
  $agama = stringdoang(urldecode($_GET['agama']));
  $penjamin = stringdoang(urldecode($_GET['penjamin']));
  if ($penjamin == ''){
    $penjamin = 'PERSONAL';
  }

  $gol_darah = stringdoang(urldecode($_GET['gol_darah']));
  $dokter_jaga = stringdoang(urldecode($_GET['dokter_jaga']));

  $kondisi = stringdoang(urldecode($_GET['kondisi']));
  $rujukan = stringdoang(urldecode($_GET['rujukan']));
  $pengantar = stringdoang(urldecode($_GET['pengantar']));
  $nama_pengantar = stringdoang(urldecode($_GET['nama_pengantar']));
  $hp_pengantar = angkadoang(urldecode($_GET['hp_pengantar']));
  $alamat_pengantar = stringdoang(urldecode($_GET['alamat_pengantar']));
  $keterangan = stringdoang(urldecode($_GET['keterangan']));
  $hubungan_dengan_pasien = stringdoang(urldecode($_GET['hubungan_dengan_pasien']));
  $eye = stringdoang(urldecode($_GET['eye']));
  $verbal = stringdoang(urldecode($_GET['verbal']));
  $motorik = stringdoang(urldecode($_GET['motorik']));
  $alergi = stringdoang(urldecode($_GET['alergi']));
  $no_kk = stringdoang(urldecode($_GET['no_kk']));
  $nama_kk = stringdoang(urldecode($_GET['nama_kk']));
  $alamat_penanggung = stringdoang(urldecode($_GET['alamat_penanggung']));

	$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
	$no_ter = mysqli_fetch_array($ambil_rm);
	echo $no_rm = urldecode($no_ter['kode_pelanggan'] + 1);

// INSERT PASIEN NYA
if ($no_rm_lama != '' ){

  $query_insert_pelanggan = $db_pasien->prepare("INSERT INTO pelanggan (alergi,kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_suamiortu,pekerjaan_suamiortu,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_pelanggan->bind_param("ssssssssssssssssssssssss",$alergi,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);
    
  $query_insert_pelanggan->execute();

  $delete_one = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");


}
else{
 
  $query_insert_regisrasi = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_regisrasi->bind_param("sssssssssssssssssssssssss", $alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,
    $tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang);

  $query_insert_regisrasi->execute();

}
// END UPDATE PASIEN

?>