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
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';

}
else {

$username = stringdoang($_SESSION['nama']);
$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$ruangan = angkadoang($_POST['ruangan']);
$umur = stringdoang($_POST['umur']);
$no_rm = stringdoang($_POST['no_rm']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$hp_pasien = angkadoang($_POST['hp_pasien']);
$kondisi = stringdoang($_POST['kondisi']);
$penjamin = stringdoang($_POST['penjamin']);
$surat_jaminan = stringdoang($_POST['surat_jaminan']);
$menginap = angkadoang($_POST['perkiraan_menginap']);
$bed = stringdoang($_POST['bed']);
$group_bed = stringdoang($_POST['group_bed']);
$poli = stringdoang($_POST['poli']);
$dokter_pengirim = stringdoang($_POST['dokter_pengirim']);
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);


$query_setting_registrasi = $db->query("SELECT tampil_ttv, tampil_data_pasien_umum FROM setting_registrasi ");
$data_setting_registrasi = mysqli_fetch_array($query_setting_registrasi);


if ($data_setting_registrasi['tampil_data_pasien_umum'] == 1) {
  $penanggung_jawab = stringdoang($_POST['penanggung_jawab']);
  $alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
  $no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
  $pekerjaan = stringdoang($_POST['pekerjaan_penanggung']);
  $hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
}
else {
  $penanggung_jawab = '';
  $alamat_penanggung = '';
  $no_hp_penanggung = '';
  $pekerjaan = '';
  $hubungan_dengan_pasien = '';
}


if ($data_setting_registrasi['tampil_ttv'] == 1) {

  $tinggi_badan = stringdoang($_POST['tinggi_badan']);
  $berat_badan = stringdoang($_POST['berat_badan']);
  $suhu = stringdoang($_POST['suhu']);
  $nadi = stringdoang($_POST['nadi']);
  $respiratory_rate = stringdoang($_POST['respiratory_rate']);
  $sistole_distole = stringdoang($_POST['sistole_distole']);
}
else {
  $tinggi_badan = '-';
  $berat_badan = '-';
  $suhu = '-';
  $nadi = '-';
  $respiratory_rate = '-';
  $sistole_distole = '-';
}


$perujuk = stringdoang($_POST['rujukan']);
$alergi = stringdoang($_POST['alergi']);


$session_id = session_id();



$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'HARI' ");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");

$no_urut = 1;
$bulan_php = date("m");
$tahun_php = date("Y");

$select_to = $db->query("SELECT nama_pasien FROM registrasi WHERE jenis_pasien = 'Rawat Inap' AND status != 'Sudah Pulang' ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap) {
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{
// START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// START UNTUK NO REG 

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

 else {

  $nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA



$query_insert_registrasi = $db->prepare("INSERT INTO registrasi (alergi,rujukan,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal_masuk,kondisi,petugas,alamat_pasien,umur_pasien,hp_pasien,bed,group_bed,menginap,dokter,dokter_pengirim,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,pekerjaan_penanggung_jawab,hubungan_dengan_pasien,jenis_kelamin,poli,jenis_pasien,tanggal,ruangan) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_registrasi->bind_param("ssssssssssssssssssssssssssssi",$alergi,$perujuk,$nama_lengkap,$jam,$penjamin,$menginap_status,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat,$umur,$hp_pasien,$bed,$group_bed,$menginap,$dokter_penanggung_jawab,$dokter_pengirim,$penanggung_jawab,$alamat_penanggung,$no_hp_penanggung,$pekerjaan,$hubungan_dengan_pasien,$jenis_kelamin,$poli,$rw_inap,$tanggal_sekarang,$ruangan);


$menginap_status = "menginap";
$rw_inap = "Rawat Inap";

$query_insert_registrasi->execute();

echo "INSERT INTO rekam_medik_inap (group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed,ruangan) VALUES ('$group_bed','$alergi','$no_reg','$no_rm','$nama_lengkap','$alamat','$umur','$jenis_kelamin','$sistole_distole','$suhu','$berat_badan','$tinggi_badan','$nadi','$respiratory_rate','$poli','$tanggal_sekarang','$jam','$dokter_pengirim','$kondisi','$perujuk','$dokter_penanggung_jawab','$bed','$ruangan')";

$sql0 = $db->prepare("INSERT INTO rekam_medik_inap (group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed,ruangan) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql0->bind_param("ssssssssssssssssssssssi",$group_bed,$alergi,$no_reg,$no_rm,$nama_lengkap,$alamat,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter_pengirim,$kondisi,$perujuk,$dokter_penanggung_jawab,$bed, $ruangan);


$sql0->execute();




// UPDATE PASIEN NYA
$query_update_pelanggan = "UPDATE pelanggan SET pekerjaan_suamiortu = '$pekerjaan', no_hp_penanggung = '$no_hp_penanggung', hubungan_dengan_pasien = '$hubungan_dengan_pasien', alamat_penanggung = '$alamat_penanggung', nama_penanggungjawab = '$penanggung_jawab', umur = '$umur',no_telp = '$hp_pasien', alamat_sekarang = '$alamat', penjamin = '$penjamin' WHERE kode_pelanggan = '$no_rm'";
if ($db_pasien->query($query_update_pelanggan) === TRUE) {
  echo 10;
} 
else {
    echo "Error: " . $query_update_pelanggan . "<br>" . $db_pasien->error;
    } 

// UPDATE KAMAR
$query_update_bed = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");
// END UPDATE KAMAR

  
// ambil bahan untuk kamar 
$query_penjamin = $db->query(" SELECT harga FROM penjamin WHERE nama = '$penjamin'");
$data_penjamin  = mysqli_fetch_array($query_penjamin);
$level_harga = $data_penjamin['harga'];

$cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed' AND group_bed = '$group_bed' ");
$kamar_luar = mysqli_fetch_array($cari_harga_kamar);
$harga_kamar1 = $kamar_luar['tarif'];
$harga_kamar2 = $kamar_luar['tarif_2'];
$harga_kamar3 = $kamar_luar['tarif_3'];
$harga_kamar4 = $kamar_luar['tarif_4'];
$harga_kamar5 = $kamar_luar['tarif_5'];
$harga_kamar6 = $kamar_luar['tarif_6'];
$harga_kamar7 = $kamar_luar['tarif_7'];
//end bahan untuk kamar


// HARGA KAMAR
if ($level_harga == 'harga_1') {
$subtotal = $menginap * $harga_kamar1;
}
else if ($level_harga == 'harga_2') {
$subtotal = $menginap * $harga_kamar2;
}
else if ($level_harga == 'harga_3') {
$subtotal = $menginap * $harga_kamar3;
}
else if ($level_harga == 'harga_4') {
$subtotal = $menginap * $harga_kamar4;
}
else if ($level_harga == 'harga_5') {
$subtotal = $menginap * $harga_kamar5;
}
else if ($level_harga == 'harga_6') {
$subtotal = $menginap * $harga_kamar6;
}
else {
$subtotal = $menginap * $harga_kamar7;
}

$query_set_kamar = $db->query(" SELECT proses_kamar FROM setting_kamar ");
$data_sett_kamar  = mysqli_fetch_array($query_set_kamar);


if ($data_sett_kamar['proses_kamar'] == 1)
{

$query_insert_tbs_penjualan = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal,ruangan) VALUES ('$session_id','$no_reg','$bed','$group_bed','$menginap','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang','$ruangan')";
      if ($db->query($query_insert_tbs_penjualan) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query_insert_tbs_penjualan . "<br>" . $db->error;
      }

}



} // end else $keluar['nama_pasien'] == $nama_lengkap
} // end else $token == ''


// Countinue data 
   // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
}// end try
 catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
} 
// ending agar data tetep masuk awalau koneksi putus 




?>
