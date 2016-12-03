<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$token = stringdoang($_POST['token']);

$pilih_akses_registrasi_ugd = $db->query("SELECT registrasi_ugd_lihat, registrasi_ugd_tambah, registrasi_ugd_edit, registrasi_ugd_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ugd = mysqli_fetch_array($pilih_akses_registrasi_ugd);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


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
$petugas = stringdoang($_SESSION['nama']);
$no_rm = stringdoang($_POST['no_rm']);
$nama_pasien =  stringdoang($_POST['nama_pasien']);
$alamat = stringdoang($_POST['alamat']);
$no_hp = angkadoang($_POST['no_hp']);
$umur = stringdoang($_POST['umur']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$gol_darah = stringdoang($_POST['gol_darah']);
$penjamin = stringdoang($_POST['penjamin']);
$pengantar = stringdoang($_POST['pengantar']);
$nama_pengantar = stringdoang($_POST['nama_pengantar']);
$hp_pengantar = angkadoang($_POST['hp_pengantar']);
$alamat_pengantar = stringdoang($_POST['alamat_pengantar']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$keterangan = stringdoang($_POST['keterangan']);
$kondisi = stringdoang($_POST['kondisi']);
$dokter_jaga = stringdoang($_POST['dokter_jaga']);
$rujukan = stringdoang($_POST['rujukan']);
$eye = stringdoang($_POST['eye']);
$verbal = stringdoang($_POST['verbal']);
$motorik = stringdoang($_POST['motorik']);
$alergi = stringdoang($_POST['alergi']);



$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d ");
$waktu = date("Y-m-d H:i:s");

$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien,no_rm FROM registrasi WHERE jenis_pasien = 'UGD' ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_pasien AND $keluar['no_rm'] == $no_rm)
{


}

else{


                                          // START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA
// START UNTUK NO REG 
//ambil 2 angka terakhir dari tahun sekarang 

 $tahun_terakhir = substr($tahun_php, 2);
//ambil bulan sekarang



 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_reg FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_reg'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_php) {
  # code...
 $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // END UNTUK AMBIL NO REG LEWAT PROSES SAJA




$sql6 = $db->prepare("INSERT INTO registrasi (eye,verbal,motorik,alergi,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal,
	kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,keterangan,dokter,pengantar_pasien,
	nama_pengantar,hp_pengantar,alamat_pengantar,hubungan_dengan_pasien,hp_pasien,jenis_pasien)
	 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

 $sql6->bind_param("ssssssssssssssssssssssssss", $eye,$verbal,$motorik,$alergi,$nama_pasien,$jam,$penjamin,$ug_stat,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$petugas,$alamat,$umur,$jenis_kelamin,$rujukan,$keterangan,$dokter_jaga,$pengantar,$nama_pengantar,
  $hp_pengantar,$alamat_pengantar,
  $hubungan_dengan_pasien,$no_hp,$ug_me);

 $ug_me = 'UGD';
 $ug_stat = 'Masuk Ruang UGD';


$sql6->execute();


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET gol_darah = '$gol_darah', umur = '$umur', no_telp = '$no_hp', alamat_sekarang = '$alamat', penjamin = '$penjamin' WHERE kode_pelanggan = '$no_rm'";
if ($db->query($update_pasien) === TRUE) 
  {
} 
else 
    {
    echo "Error: " . $update_pasien . "<br>" . $db->error;
    }



$query11 = $db->prepare("INSERT INTO rekam_medik_ugd (tanggal,jam,no_reg,no_rm,nama,jenis_kelamin,umur,alamat,eye,verbal,motorik,rujukan,
  pengantar,alergi,keadaan_umum,dokter)
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query11->bind_param("ssssssssssssssss", $tanggal_sekarang,$jam,$no_reg,$no_rm,$nama_pasien,$jenis_kelamin,$umur,$alamat,$eye,$verbal,$motorik,
  $rujukan,$pengantar,$alergi,$kondisi,$dokter_jaga);

$query11->execute();



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
