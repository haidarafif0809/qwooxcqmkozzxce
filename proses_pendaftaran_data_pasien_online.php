<?php 
include 'db.php';
include 'sanitasi.php';

//DATA YANG DIBUTUHKAN DI PROSES PENDAFTARAN PASIEN BARU
  $nama_lengkap = stringdoang(urldecode($_GET['nama_lengkap']));
  $jenis_kelamin = stringdoang(urldecode($_GET['jenis_kelamin']));
  $tanggal_lahir = stringdoang(urldecode(tanggal_mysql($_GET['tanggal_lahir'])));
  $umur = stringdoang(urldecode($_GET['umur']));
  $tempat_lahir = stringdoang(urldecode($_GET['tempat_lahir']));
  $alamat_sekarang = stringdoang(urldecode($_GET['alamat_sekarang']));
  $no_ktp = angkadoang(urldecode($_GET['no_ktp']));
  $alamat_ktp = stringdoang(urldecode($_GET['alamat_ktp']));
  $no_hp = angkadoang(urldecode($_GET['no_hp']));
  $status_kawin = stringdoang(urldecode($_GET['status_kawin']));
  $pendidikan_terakhir = stringdoang(urldecode($_GET['pendidikan_terakhir']));
  $agama = stringdoang(urldecode($_GET['agama']));
  $nama_suamiortu = stringdoang(urldecode($_GET['nama_suamiortu']));
  $pekerjaan_suamiortu = stringdoang(urldecode($_GET['pekerjaan_suamiortu']));
  $nama_penanggungjawab = stringdoang(urldecode($_GET['nama_penanggungjawab']));
  $hubungan_dengan_pasien = stringdoang(urldecode($_GET['hubungan_dengan_pasien']));
  $no_hp_penanggung = stringdoang(urldecode($_GET['no_hp_penanggung']));
  $alamat_penanggung = stringdoang(urldecode($_GET['alamat_penanggung']));
  $no_kk = angkadoang(urldecode($_GET['no_kk']));
  $nama_kk = stringdoang(urldecode($_GET['nama_kk']));
  $gol_darah = stringdoang(urldecode($_GET['gol_darah']));
  $penjamin = stringdoang(urldecode($_GET['penjamin']));

	$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
	$no_ter = mysqli_fetch_array($ambil_rm);
	$no_rm = urldecode($no_ter['kode_pelanggan'] + 1);

// INSERT PASIEN NYA
  $query_insert_pasien = $db_pasien->prepare("INSERT INTO pelanggan (kode_pelanggan, nama_pelanggan, jenis_kelamin, tgl_lahir, umur, tempat_lahir, alamat_sekarang, no_ktp, alamat_ktp, no_telp, status_kawin, pendidikan_terakhir, agama, nama_suamiortu, pekerjaan_suamiortu, nama_penanggungjawab, hubungan_dengan_pasien, no_hp_penanggung, alamat_penanggung, no_kk, nama_kk, gol_darah, penjamin, tanggal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_pasien->bind_param("sssssssisisssssssssissss",
  $no_rm, $nama_lengkap, $jenis_kelamin, $tanggal_lahir, $umur, $tempat_lahir, $alamat_sekarang, $no_ktp, $alamat_ktp, $no_hp, $status_kawin, $pendidikan_terakhir, $agama, $nama_suamiortu, $pekerjaan_suamiortu, $nama_penanggungjawab, $hubungan_dengan_pasien, $no_hp_penanggung, $alamat_penanggung, $no_kk, $nama_kk, $gol_darah, $penjamin, $tanggal_sekarang);

  $query_insert_pasien->execute();

  if (!$query_insert_pasien) {
      die('Query Error : '.$db_pasien->errno.
      ' - '.$db_pasien->error);
    }
  else { 
    
  }

?>