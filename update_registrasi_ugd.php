<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang(urlencode($_POST['token']));

// start data agar tetap masuk 
try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
 // begin data

if ($token == '')
{


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';  

}
else
{
$username = $_SESSION['user_name'];


$no_reg = stringdoang(urlencode($_POST['no_reg']));
$no_rm_lama = stringdoang(urlencode($_POST['no_rm_lama']));
$nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
$no_ktp = stringdoang(urlencode($_POST['no_ktp']));
$tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
$tanggal_lahir = stringdoang(urlencode($_POST['tanggal_lahir']));
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$umur = stringdoang(urlencode($_POST['umur']));
$alamat_sekarang = stringdoang(urlencode($_POST['alamat_sekarang']));
$alamat_ktp = stringdoang(urlencode($_POST['alamat_ktp']));
$no_telepon = angkadoang(urlencode($_POST['no_telepon']));
$nama_suamiortu = stringdoang(urlencode($_POST['nama_suamiortu']));
$pekerjaan_pasien = stringdoang(urlencode($_POST['pekerjaan_pasien']));
$jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
$status_kawin = stringdoang(urlencode($_POST['status_kawin']));
$pendidikan_terakhir = stringdoang(urlencode($_POST['pendidikan_terakhir']));
$agama = stringdoang(urlencode($_POST['agama']));
$penjamin = stringdoang(urlencode($_POST['penjamin']));
$gol_darah = stringdoang(urlencode($_POST['gol_darah']));
$dokter_jaga = stringdoang(urlencode($_POST['dokter_jaga']));
$kondisi = stringdoang(urlencode($_POST['kondisi']));
$rujukan = stringdoang(urlencode($_POST['rujukan']));
$pengantar = stringdoang(urlencode($_POST['pengantar']));
$nama_pengantar = stringdoang(urlencode($_POST['nama_pengantar']));
$hp_pengantar = angkadoang(urlencode($_POST['hp_pengantar']));
$alamat_pengantar = stringdoang(urlencode($_POST['alamat_pengantar']));
$keterangan = stringdoang(urlencode($_POST['keterangan']));
$hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
$eye = stringdoang(urlencode($_POST['eye']));
$verbal = stringdoang(urlencode($_POST['verbal']));
$motorik = stringdoang(urlencode($_POST['motorik']));
$alergi = stringdoang(urlencode($_POST['alergi']));
$no_kk = stringdoang(urlencode($_POST['no_kk']));
$nama_kk = stringdoang(urlencode($_POST['nama_kk']));
$alamat_penanggung = stringdoang(urlencode($_POST['alamat_penanggung']));

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$delete_rekam_medik = $db->query("DELETE FROM rekam_medik_ugd WHERE no_reg = '$no_reg'");

$query_data_registrasi = $db->query("SELECT nama_pasien,no_rm FROM registrasi WHERE jenis_pasien = 'UGD'  ORDER BY id DESC LIMIT 1 ")->fetch_array();

if ($query_data_registrasi['nama_pasien'] == $nama_lengkap AND $query_data_registrasi['no_rm'] == $no_rm)
{
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';
}
else{


// ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA
$sql_update = $db->prepare("UPDATE registrasi SET eye= ?, verbal= ?, motorik= ?, alergi= ?, nama_pasien= ?, jam= ?,
  penjamin= ?,status= ?, no_rm= ?, tanggal= ?, kondisi= ?, petugas= ?, alamat_pasien= ?, umur_pasien= ?,
  jenis_kelamin= ?,rujukan= ?,jenis_pasien= ?, gol_darah= ?, status_nikah= ?, pekerjaan_pasien= ?,
  pengantar_pasien= ?, nama_pengantar= ?, hp_pengantar= ?, alamat_pengantar= ?, keterangan= ?, hubungan_dengan_pasien= ?,
  dokter= ?, hp_pasien = ? WHERE no_reg = ?");

$sql_update->bind_param("sssssssssssssssssssssssssssss",urldecode($eye),urldecode($verbal),urldecode($motorik),urldecode($alergi),urldecode($nama_lengkap),urldecode($jam),urldecode($penjamin),$status_ugd,urldecode($no_rm_lama),urldecode($tanggal_sekarang),urldecode($kondisi),urldecode($username),urldecode($alamat_ktp),urldecode($umur),urldecode($jenis_kelamin),urldecode($rujukan),$jenis_registrasi,urldecode($gol_darah),urldecode($status_kawin),urldecode($pekerjaan_pasien),urldecode($pengantar),urldecode($nama_pengantar),urldecode($hp_pengantar),urldecode($alamat_pengantar),urldecode($keterangan),urldecode($hubungan_dengan_pasien),urldecode($dokter_jaga),urldecode($no_telepon),urldecode($no_reg));

$status_ugd = 'Masuk Ruang UGD';
$jenis_registrasi = 'UGD';

$sql_update->execute();


$query_rekam_medik = $db->prepare("INSERT INTO rekam_medik_ugd (tanggal,jam,no_reg,no_rm,nama,jenis_kelamin,umur,alamat,eye,verbal,motorik,rujukan,pengantar,alergi,keadaan_umum,dokter) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_rekam_medik->bind_param("ssssssssssssssss", urldecode($tanggal_sekarang),urldecode($jam),urldecode($no_reg),urldecode($no_rm_lama),urldecode($nama_lengkap),urldecode($jenis_kelamin),urldecode($umur),urldecode($alamat_sekarang),urldecode($eye),urldecode($verbal), urldecode($motorik),urldecode($rujukan),urldecode($pengantar),urldecode($alergi),urldecode($kondisi),urldecode($dokter_jaga));

$query_rekam_medik->execute();


//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU UGD
  $data_reg_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '8' ")->fetch_array();

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&tempat_lahir='.$tempat_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&penjamin='.$penjamin.'&no_telepon='.$no_telepon;

 $file_get = file_get_contents($data_url);
//PROSES INPUT PASIEN KE DB ONLINE

 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';


} // biar gk double 
} // token

// Countinue data 
   // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

 ?>