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

	$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
	$no_ter = mysqli_fetch_array($ambil_rm);
	echo $no_rm = urldecode($no_ter['kode_pelanggan'] + 1);

// INSERT PASIEN NYA
    if ($no_rm_lama != '' ){

      $query_insert_rm_tidak_kosong = $db_pasien->prepare("INSERT INTO pelanggan (kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,no_telp,jenis_kelamin,agama,alergi,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

      $query_insert_rm_tidak_kosong->bind_param("sssssssssssss",$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat,$no_telepon,$jenis_kelamin,$agama,$alergi,$gol_darah,$tanggal_sekarang,$no_rm_lama);

      $query_insert_rm_tidak_kosong->execute();

      $query_hapus_sesuai_rm_lama = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");

    }
    else{

      $query_insert_rm_lama_kosong = $db_pasien->prepare("INSERT INTO pelanggan (kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,no_telp,jenis_kelamin,agama,alergi,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

      $query_insert_rm_lama_kosong->bind_param("sssssssssssss",$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat,$no_telepon,$jenis_kelamin,$agama,$alergi,$gol_darah,$tanggal_sekarang,$no_rm_lama);

      $query_insert_rm_lama_kosong->execute();
    }
// END UPDATE PASIEN

?>