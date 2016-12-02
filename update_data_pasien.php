<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$umur = stringdoang($_POST['umur']);
$tempat_lahir = stringdoang($_POST['tempat_lahir']);
$alamat_sekarang = stringdoang($_POST['alamat_sekarang']);
$no_ktp = stringdoang($_POST['no_ktp']);
$alamat_ktp = stringdoang($_POST['alamat_ktp']);
$no_hp = stringdoang($_POST['no_hp']);
$status_kawin = stringdoang($_POST['status_kawin']);
$pendidikan_terakhir = stringdoang($_POST['pendidikan_terakhir']);
$agama = stringdoang($_POST['agama']);
$nama_suamiortu = stringdoang($_POST['nama_suamiortu']);
$pekerjaan_suamiortu = stringdoang($_POST['pekerjaan_suamiortu']);
$nama_penanggungjawab = stringdoang($_POST['nama_penanggungjawab']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$no_kk = stringdoang($_POST['no_kk']);
$nama_kk = stringdoang($_POST['nama_kk']);
$gol_darah = stringdoang($_POST['gol_darah']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);


$tanggal_sekarang = date("Y-m-d");


$perintah = $db->prepare("UPDATE pelanggan SET  nama_pelanggan = ?, jenis_kelamin = ?, tgl_lahir = ?, umur = ?, tempat_lahir = ?, alamat_sekarang = ?, no_ktp = ?, alamat_ktp = ?, no_telp = ?, status_kawin = ?, pendidikan_terakhir = ?, agama = ?, nama_suamiortu = ?, pekerjaan_suamiortu = ?, nama_penanggungjawab = ?, hubungan_dengan_pasien = ?, no_hp_penanggung = ?, alamat_penanggung = ?, no_kk = ?, nama_kk = ?, gol_darah = ?, tanggal = ? WHERE id = ? ");


$perintah->bind_param("ssssssisisssssssssisssi",

$nama_lengkap, $jenis_kelamin, $tanggal_lahir, $umur, $tempat_lahir, $alamat_sekarang, $no_ktp, $alamat_ktp, $no_hp, $status_kawin, $pendidikan_terakhir, $agama, $nama_suamiortu, $pekerjaan_suamiortu, $nama_penanggungjawab, $hubungan_dengan_pasien, $no_hp_penanggung, $alamat_penanggung, $no_kk, $nama_kk, $gol_darah, $tanggal_sekarang, $id);



$perintah->execute();

    if (!$perintah) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {   
    	header("location:pasien.php");
    }

 ?>