<?php 
include 'db.php';
include 'sanitasi.php';


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
  $no_telepon = stringdoang(urldecode($_GET['no_telepon']));
  $pekerjaan_penanggung = stringdoang(urldecode($_GET['pekerjaan_penanggung']));
  $nama_penanggungjawab = stringdoang(urldecode($_GET['nama_penanggungjawab']));
  $hubungan_dengan_pasien = stringdoang(urldecode($_GET['hubungan_dengan_pasien']));
  $no_hp_penanggung = stringdoang(urldecode($_GET['no_hp_penanggung']));
  $alamat_penanggung = stringdoang(urldecode($_GET['alamat_penanggung']));
  $jenis_kelamin = stringdoang(urldecode($_GET['jenis_kelamin']));
  $status_kawin = stringdoang(urldecode($_GET['status_kawin']));
  $pendidikan_terakhir = stringdoang(urldecode($_GET['pendidikan_terakhir']));
  $agama = stringdoang(urldecode($_GET['agama']));
  $penjamin = stringdoang(urldecode($_GET['penjamin']));
  if ($penjamin == ''){
    $penjamin = 'PERSONAL';
  }

  $gol_darah = stringdoang(urldecode($_GET['gol_darah']));
  $poli = stringdoang(urldecode($_GET['poli']));
  $kondisi = stringdoang(urldecode($_GET['kondisi']));
  $rujukan = stringdoang(urldecode($_GET['rujukan']));
  $sistole_distole = stringdoang(urldecode($_GET['sistole_distole']));
  $respiratory_rate = stringdoang(urldecode($_GET['respiratory_rate']));
  $suhu = stringdoang(urldecode($_GET['suhu']));
  $nadi = stringdoang(urldecode($_GET['nadi']));
  $berat_badan = stringdoang(urldecode($_GET['berat_badan']));
  $tinggi_badan = stringdoang(urldecode($_GET['tinggi_badan']));
  $alergi = stringdoang(urldecode($_GET['alergi']));
  $no_kk = stringdoang(urldecode($_GET['no_kk']));
  $nama_kk = stringdoang(urldecode($_GET['nama_kk']));
  $group_bed = stringdoang(urldecode($_GET['group_bed']));
  $bed = stringdoang(urldecode($_GET['bed']));
  $perkiraan_menginap = angkadoang(urldecode($_GET['perkiraan_menginap']));
  $surat_jaminan = stringdoang(urldecode($_GET['surat_jaminan']));
  $dokter_pj = stringdoang(urldecode($_GET['dokter_penanggung_jawab']));
  $dokter_jg = stringdoang(urldecode($_GET['dokter']));
  $ruangan_split = stringdoang(urldecode($_GET['ruangan']));
	$token = stringdoang(urldecode($_GET['token']));

	$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
	$no_ter = mysqli_fetch_array($ambil_rm);
	echo $no_rm = urldecode($no_ter['kode_pelanggan'] + 1);

// INSERT PASIEN NYA
if ($no_rm_lama != ''){

	$query_insert_pelanggan = $db_pasien->prepare("INSERT INTO pelanggan(alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_penanggungjawab,hubungan_dengan_pasien,alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

	$query_insert_pelanggan->bind_param("ssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);

	$query_insert_pelanggan->execute();

	$query_delete = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");


}
else{

	$query_insert_pelanggan_lagi = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_penanggungjawab,hubungan_dengan_pasien,alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

	$query_insert_pelanggan_lagi->bind_param("sssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang);

	$query_insert_pelanggan_lagi->execute();

}
// END UPDATE PASIEN

?>