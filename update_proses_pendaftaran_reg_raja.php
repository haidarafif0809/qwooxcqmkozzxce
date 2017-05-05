<?php include 'session_login.php'; 
include 'db.php';
include_once 'sanitasi.php';

$token = stringdoang($_POST['token']);

// start data agar tetap masuk 
try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
 // begin data

if ($token == '')
{
  
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_raja.php">';

}

else
{
$username = $_SESSION['nama'];

$no_rm = stringdoang($_POST['no_rm_lama']);
$no_reg = stringdoang($_POST['no_reg']);

$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$no_ktp = stringdoang($_POST['no_ktp']);
$tempat_lahir = stringdoang($_POST['tempat_lahir']);
$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$umur = stringdoang($_POST['umur']);
$alamat_sekarang = stringdoang($_POST['alamat_sekarang']);
$alamat_ktp = stringdoang($_POST['alamat_ktp']);
$no_telepon = stringdoang($_POST['no_telepon']);
$nama_suamiortu = stringdoang($_POST['nama_suamiortu']);
$pekerjaan_pasien = stringdoang($_POST['pekerjaan_pasien']);
$nama_penanggungjawab = stringdoang($_POST['nama_penanggungjawab']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$status_kawin = stringdoang($_POST['status_kawin']);
$pendidikan_terakhir = stringdoang($_POST['pendidikan_terakhir']);
$agama = stringdoang($_POST['agama']);
$penjamin = stringdoang($_POST['penjamin']);
$gol_darah = stringdoang($_POST['gol_darah']);
$poli = stringdoang($_POST['poli']);
$dokter = stringdoang($_POST['dokter']);
$kondisi = stringdoang($_POST['kondisi']);
$rujukan = stringdoang($_POST['rujukan']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$respiratory_rate = stringdoang($_POST['respiratory_rate']);
$suhu = stringdoang($_POST['suhu']);
$nadi = stringdoang($_POST['nadi']);
$berat_badan = stringdoang($_POST['berat_badan']);
$tinggi_badan = stringdoang($_POST['tinggi_badan']);
$alergi = stringdoang($_POST['alergi']);
$no_kk = stringdoang($_POST['no_kk']);
$nama_kk = stringdoang($_POST['nama_kk']);
$no_urut = stringdoang($_POST['no_urut']);
$status_registrasi = stringdoang($_POST['status_pasien']);

$tgl = date('Y-m-d');
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

if ($status_registrasi == 'pasien_masuk')
{
  $menunggu = 'Proses';
}
else
{
  $menunggu = 'menunggu';
}

$rawat_jalan_nya = 'Rawat Jalan';
 
$stmt = $db->query("UPDATE registrasi SET alergi = '$alergi', no_kk = '$no_kk', nama_kk = '$nama_kk', poli = '$poli', no_urut = '$no_urut', nama_pasien = '$nama_lengkap', jam = '$jam', penjamin = '$penjamin', dokter = '$dokter', status = '$menunggu', 
  no_reg = '$no_reg', no_rm = '$no_rm', tanggal = '$tanggal_sekarang', kondisi = '$kondisi', petugas = '$username', alamat_pasien = '$alamat_ktp', umur_pasien = '$umur', jenis_kelamin = '$jenis_kelamin', rujukan = '$rujukan', jenis_pasien = '$rawat_jalan_nya', 
  gol_darah = '$gol_darah', penanggung_jawab = '$nama_penanggungjawab', alamat_penanggung_jawab = '$alamat_penanggung', hp_penanggung_jawab = '$no_hp_penanggung', status_nikah = '$status_kawin', pekerjaan_pasien = '$pekerjaan_pasien' WHERE no_reg = '$no_reg' ");

// masukin ke rekam medik 


// insert rekam medik 
$hapus_rekam_medik = $db->query("DELETE FROM rekam_medik WHERE no_reg = '$no_reg'");

$sql0 = $db->prepare("INSERT INTO rekam_medik(alergi,no_kk,nama_kk,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,
  nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql0->bind_param("sssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_reg,$no_rm,$nama_lengkap,$alamat_sekarang,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter,$kondisi,$rujukan);

$sql0->execute();
//insert rekam medik


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET umur = '$umur',no_telp = '$no_telepon', alamat_sekarang = '$alamat_sekarang', penjamin = '$penjamin' , nama_pelanggan = '$nama_lengkap' , tempat_lahir = '$tempat_lahir', alamat_ktp = '$alamat_ktp', no_ktp = '$no_ktp', status_kawin = '$status_kawin', agama = '$agama' WHERE kode_pelanggan = '$no_rm'";
if ($db_pasien->query($update_pasien) === TRUE) 
  {
} 
else 
    {
    echo "Error: " . $update_pasien . "<br>" . $db_pasien->error;
    } 
// UPDATE PASIEN 



} // token
//penutup untuk cancel double klick

    $db->commit();
if ($status_registrasi == 'pasien_masuk')
{
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pasien_sudah_masuk.php">';

}
else
{
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_raja.php">';

}

} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

mysqli_close($db);

?>