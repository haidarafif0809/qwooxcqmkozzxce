<?php 
include 'db.php';
include 'sanitasi.php';




$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan ORDER BY kode_pelanggan DESC LIMIT 1 ");
$no_ter = mysqli_fetch_array($ambil_rm);
$no_rm = $no_ter['kode_pelanggan'] + 1;

$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$tanggal_lahir = tanggal_mysql($_POST['tanggal_lahir']);
$umur = stringdoang($_POST['umur']);
$tempat_lahir = stringdoang($_POST['tempat_lahir']);
$alamat_sekarang = stringdoang($_POST['alamat_sekarang']);
$no_ktp = angkadoang($_POST['no_ktp']);
$alamat_ktp = stringdoang($_POST['alamat_ktp']);
$no_hp = angkadoang($_POST['no_hp']);
$status_kawin = stringdoang($_POST['status_kawin']);
$pendidikan_terakhir = stringdoang($_POST['pendidikan_terakhir']);
$agama = stringdoang($_POST['agama']);
$nama_suamiortu = stringdoang($_POST['nama_suamiortu']);
$pekerjaan_suamiortu = stringdoang($_POST['pekerjaan_suamiortu']);
$nama_penanggungjawab = stringdoang($_POST['nama_penanggungjawab']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$no_kk = angkadoang($_POST['no_kk']);
$nama_kk = stringdoang($_POST['nama_kk']);
$gol_darah = stringdoang($_POST['gol_darah']);
$penjamin = stringdoang($_POST['penjamin']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);

$perintah = $db_pasien->prepare("INSERT INTO pelanggan (
  kode_pelanggan,
  nama_pelanggan,
  jenis_kelamin,
  tgl_lahir,
  umur,
  tempat_lahir,
  alamat_sekarang,
  no_ktp,
  alamat_ktp,
  no_telp,
  status_kawin,
  pendidikan_terakhir,
  agama,
  nama_suamiortu,
  pekerjaan_suamiortu,
  nama_penanggungjawab,
  hubungan_dengan_pasien,
  no_hp_penanggung,
  alamat_penanggung,
  no_kk,
  nama_kk,
  gol_darah,
  penjamin,
  tanggal)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$perintah->bind_param("sssssssisisssssssssissss",
$no_rm,
$nama_lengkap,
$jenis_kelamin,
$tanggal_lahir,
$umur,
$tempat_lahir,
$alamat_sekarang,
$no_ktp,
$alamat_ktp,
$no_hp,
$status_kawin,
$pendidikan_terakhir,
$agama,
$nama_suamiortu,
$pekerjaan_suamiortu,
$nama_penanggungjawab,
$hubungan_dengan_pasien,
$no_hp_penanggung,
$alamat_penanggung,
$no_kk,
$nama_kk,
$gol_darah,
$penjamin,
$tanggal_sekarang);


$perintah->execute();

    if (!$perintah) 
    {
    die('Query Error : '.$db_pasien->errno.
    ' - '.$db_pasien->error);
    }
    else 
    {   
      header("location:pasien.php");

    }




//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db_pasien);   

    ?>

