<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang($_POST['token']);

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

$no_rm_lama = stringdoang($_POST['no_rm_lama']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$no_ktp = stringdoang($_POST['no_ktp']);
$tempat_lahir = stringdoang($_POST['tempat_lahir']);
$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$umur = stringdoang($_POST['umur']);
$alamat_sekarang = stringdoang($_POST['alamat_sekarang']);
$alamat_ktp = stringdoang($_POST['alamat_ktp']);
$no_telepon = angkadoang($_POST['no_telepon']);
$nama_suamiortu = stringdoang($_POST['nama_suamiortu']);
$pekerjaan_pasien = stringdoang($_POST['pekerjaan_pasien']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$status_kawin = stringdoang($_POST['status_kawin']);
$pendidikan_terakhir = stringdoang($_POST['pendidikan_terakhir']);
$agama = stringdoang($_POST['agama']);
$penjamin = stringdoang($_POST['penjamin']);
$gol_darah = stringdoang($_POST['gol_darah']);
$dokter_jaga = stringdoang($_POST['dokter_jaga']);
$kondisi = stringdoang($_POST['kondisi']);
$rujukan = stringdoang($_POST['rujukan']);
$pengantar = stringdoang($_POST['pengantar']);
$nama_pengantar = stringdoang($_POST['nama_pengantar']);
$hp_pengantar = angkadoang($_POST['hp_pengantar']);
$alamat_pengantar = stringdoang($_POST['alamat_pengantar']);
$keterangan = stringdoang($_POST['keterangan']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$eye = stringdoang($_POST['eye']);
$verbal = stringdoang($_POST['verbal']);
$motorik = stringdoang($_POST['motorik']);
$alergi = stringdoang($_POST['alergi']);
$no_kk = stringdoang($_POST['no_kk']);
$nama_kk = stringdoang($_POST['nama_kk']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);



$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien FROM registrasi WHERE jenis_pasien = 'UGD'  ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap AND $keluar['no_rm'] == $no_rm)
{
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';
}
else{

// START NO. RM PASIEN
$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan ORDER BY kode_pelanggan DESC LIMIT 1 ");
$no_ter = mysqli_fetch_array($ambil_rm);
$no_rm = $no_ter['kode_pelanggan'] + 1;



// END NO. RM PASIEN


// START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// START UNTUK NO REG 
//ambil 2 angka terakhir dari tahun sekarang 

 $tahun_terakhir = substr($tahun_php, 2);

//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
$bulan_terakhir_reg = $v_bulan_terakhir['bulan'];
//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_reg FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_reg'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($bulan_terakhir_reg != $bulan_php) {
  # code...
 $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

$sql6 = $db->prepare("INSERT INTO registrasi (eye,verbal,motorik,alergi,nama_pasien,jam,penjamin,status,
  no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,
  gol_darah,status_nikah,pekerjaan_pasien,pengantar_pasien,nama_pengantar,hp_pengantar,alamat_pengantar,keterangan,hubungan_dengan_pasien,dokter,hp_pasien) 
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql6->bind_param("sssssssssssssssssssssssssssss",$eye,$verbal,$motorik,$alergi,$nama_lengkap
  ,$jam,$penjamin,$sig_in_ugd,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_ktp,$umur
  ,$jenis_kelamin,$rujukan,$ugd_ku,$gol_darah,$status_kawin,$pekerjaan_pasien,$pengantar,$nama_pengantar,$hp_pengantar,$alamat_pengantar,$keterangan,$hubungan_dengan_pasien,$dokter_jaga,$no_telepon);

$sig_in_ugd = 'Masuk Ruang UGD';
$ugd_ku = 'UGD';

$sql6->execute();


if ($no_rm_lama != '' ){



$sql9 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,
  nama_suamiortu,pekerjaan_suamiortu,jenis_kelamin,pendidikan_terakhir,
  status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql9->bind_param("ssssssssssssssssssssssss",$alergi,$provinsi,$kabupaten,$kecamatan,$kelurahan,$no_rm,$nama_lengkap,$tempat_lahir,
  $tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,
  $pekerjaan_pasien,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,
  $penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);

$sql9->execute();



$delete_one = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND no_rm IS NULL ");


}
else{

 
$sql9901 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,
  nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,
  alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,
  status_kawin,agama,penjamin,gol_darah,tanggal)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $sql9901->bind_param("sssssssssssssssssssssssss", $alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,
    $tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,
    $hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,
  $penjamin,$gol_darah,$tanggal_sekarang);

$sql9901->execute();



}

$query11 = $db->prepare("INSERT INTO rekam_medik_ugd (tanggal,jam,no_reg,no_rm,nama,jenis_kelamin,umur,alamat,eye,verbal,motorik,rujukan,pengantar,alergi,keadaan_umum,dokter) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query11->bind_param("ssssssssssssssss", $tanggal_sekarang,$jam,$no_reg,$no_rm,$nama_lengkap,$jenis_kelamin,$umur,$alamat_sekarang,$eye,$verbal, $motorik,$rujukan,$pengantar,$alergi,$kondisi,$dokter_jaga);

$query11->execute();

                                      // ENDING UNTUK AMBIL NO FAKTUR (PENJUALAN)


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

mysqli_close($db);

 ?>

 <!---->