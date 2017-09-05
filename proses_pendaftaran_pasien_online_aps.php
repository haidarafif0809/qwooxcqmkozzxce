<?php 
include 'db.php';
include 'sanitasi.php';

//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $no_rm_lama = stringdoang(urldecode($_GET['no_rm_lama']));
  $nama_lengkap = stringdoang(urldecode($_GET['nama_lengkap']));
  $jenis_kelamin = stringdoang(urldecode($_GET['jenis_kelamin']));
  $tempat_lahir = stringdoang(urldecode($_GET['tempat_lahir']));
  $tanggal_lahir = stringdoang(urldecode(tanggal_mysql($_GET['tanggal_lahir'])));
  $umur = stringdoang(urldecode($_GET['umur']));
  $gol_darah = stringdoang(urldecode($_GET['gol_darah']));
  $alamat = stringdoang(urldecode($_GET['alamat']));
  $no_telepon = stringdoang(urldecode($_GET['no_telepon']));
  $agama = stringdoang(urldecode($_GET['agama']));
  $alergi = stringdoang(urldecode($_GET['alergi']));

	$query_pelanggan = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ")->fetch_array();
	echo $no_rm = urldecode($query_pelanggan['kode_pelanggan'] + 1);

//JIKA ADA MIGRASI PASIEN
    if ($no_rm_lama != '' ){
      $no_rm_lama = stringdoang(urldecode($_GET['no_rm_lama']));
      $query_hapus_sesuai_rm_lama = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");
    }
    else{
      $no_rm_lama = "";
    }

//INSERT DATA PASIEN BARU
      $query_insert_rm_tidak_kosong = $db_pasien->prepare("INSERT INTO pelanggan (kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,no_telp,jenis_kelamin,agama,alergi,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

      $query_insert_rm_tidak_kosong->bind_param("sssssssssssss",$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat,$no_telepon,$jenis_kelamin,$agama,$alergi,$gol_darah,$tanggal_sekarang,$no_rm_lama);

      $query_insert_rm_tidak_kosong->execute();
// END UPDATE PASIEN

?>