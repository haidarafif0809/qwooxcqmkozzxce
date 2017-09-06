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

$no_reg = stringdoang(urldecode($_POST['no_reg']));
$no_rm_lama = stringdoang(urldecode($_POST['no_rm_lama']));
$nama_lengkap = stringdoang(urldecode($_POST['nama_lengkap']));
$no_ktp = stringdoang(urldecode($_POST['no_ktp']));
$tempat_lahir = stringdoang(urldecode($_POST['tempat_lahir']));
$tanggal_lahir = stringdoang(urldecode($_POST['tanggal_lahir']));
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$umur = stringdoang(urldecode($_POST['umur']));
$alamat_sekarang = stringdoang(urldecode($_POST['alamat_sekarang']));
$alamat_ktp = stringdoang(urldecode($_POST['alamat_ktp']));
$no_telepon = angkadoang(urldecode($_POST['no_telepon']));
$nama_suamiortu = stringdoang(urldecode($_POST['nama_suamiortu']));
$pekerjaan_pasien = stringdoang(urldecode($_POST['pekerjaan_pasien']));
$jenis_kelamin = stringdoang(urldecode($_POST['jenis_kelamin']));
$status_kawin = stringdoang(urldecode($_POST['status_kawin']));
$pendidikan_terakhir = stringdoang(urldecode($_POST['pendidikan_terakhir']));
$agama = stringdoang(urldecode($_POST['agama']));
$penjamin = stringdoang(urldecode($_POST['penjamin']));
$gol_darah = stringdoang(urldecode($_POST['gol_darah']));
$dokter_jaga = stringdoang(urldecode($_POST['dokter_jaga']));
$kondisi = stringdoang(urldecode($_POST['kondisi']));
$rujukan = stringdoang(urldecode($_POST['rujukan']));
$pengantar = stringdoang(urldecode($_POST['pengantar']));
$nama_pengantar = stringdoang(urldecode($_POST['nama_pengantar']));
$hp_pengantar = angkadoang(urldecode($_POST['hp_pengantar']));
$alamat_pengantar = stringdoang(urldecode($_POST['alamat_pengantar']));
$keterangan = stringdoang(urldecode($_POST['keterangan']));
$hubungan_dengan_pasien = stringdoang(urldecode($_POST['hubungan_dengan_pasien']));
$eye = stringdoang(urldecode($_POST['eye']));
$verbal = stringdoang(urldecode($_POST['verbal']));
$motorik = stringdoang(urldecode($_POST['motorik']));
$alergi = stringdoang(urldecode($_POST['alergi']));
$no_kk = stringdoang(urldecode($_POST['no_kk']));
$nama_kk = stringdoang(urldecode($_POST['nama_kk']));
$alamat_penanggung = stringdoang(urldecode($_POST['alamat_penanggung']));

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');


// START NO. RM PASIEN
$data_pelanggan = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan ORDER BY id DESC LIMIT 1 ")->fetch_array();
$no_rm = $data_pelanggan['kode_pelanggan'] + 1;
// END NO. RM PASIEN


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET umur = '$umur',no_telp = '$no_telepon', alamat_sekarang = '$alamat_sekarang', penjamin = '$penjamin' , nama_pelanggan = '$nama_lengkap' , tempat_lahir = '$tempat_lahir' WHERE kode_pelanggan = '$no_rm'";
if ($db_pasien->query($update_pasien) === TRUE) 
  {
} 
else{
    echo "Error: " . $update_pasien . "<br>" . $db_pasien->error;
    } 
// UPDATE PASIEN 


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';

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

mysqli_close($db);

 ?>

 <!---->