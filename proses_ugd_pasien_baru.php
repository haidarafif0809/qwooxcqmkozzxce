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

if ($token == ''){
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';
}
else{
  $username = $_SESSION['nama'];

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
  if ($penjamin == ''){
    $penjamin = 'PERSONAL';
  }

  $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
  $dokter_jg = stringdoang(urlencode($_POST['dokter_jaga']));
  $dokter_jg = explode("-", $dokter_jg);
  $id_dokter_jaga = $dokter_jg[0];
  $dokter_jaga = $dokter_jg[1];

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

  $query_registrasi = $db->query("SELECT nama_pasien FROM registrasi WHERE jenis_pasien = 'UGD'  ORDER BY id DESC LIMIT 1 ");
  $data_registrasi = mysqli_fetch_array($query_registrasi);

if ($data_registrasi['nama_pasien'] == $nama_lengkap){
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_ugd.php">';
}
else{
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
  $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;
 }
 else {
  $nomor = 1 + $ambil_nomor ;
  $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;
 }

   $query_penjamin = $db->query("SELECT harga FROM penjamin WHERE nama = '$penjamin'");
   $data_penjamin  = mysqli_fetch_array($query_penjamin);
   $level_harga = $data_penjamin['harga'];
// AKHIR UNTUK NO REG

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU UGD
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '4' ");
  $data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap
  .'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&nama_suamiortu='.$nama_suamiortu.'&pekerjaan_pasien='.$pekerjaan_pasien.'&jenis_kelamin='.$jenis_kelamin.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&penjamin='.$penjamin.'&gol_darah='.$gol_darah.'&id_dokter_jaga='.$id_dokter_jaga.'&dokter_jaga='.$dokter_jaga.'&kondisi='.$kondisi.'&rujukan='.$rujukan.'&pengantar='.$pengantar.'&nama_pengantar='.$nama_pengantar.'&hp_pengantar='.$hp_pengantar.'&alamat_pengantar='.$alamat_pengantar.'&keterangan='.$keterangan.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&eye='.$eye.'&verbal='.$verbal.'&motorik='.$motorik.'&alergi='.$alergi.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&alamat_penanggung='.$alamat_penanggung;

  $file_get = file_get_contents($data_url);

//ambil no rm dari DB
  $no_rm = $file_get;

// INSERT KE REGISTRASI
  $query_insert_regisrasi = $db->prepare("INSERT INTO registrasi (eye,verbal,motorik,alergi,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,gol_darah,status_nikah,pekerjaan_pasien,pengantar_pasien,nama_pengantar,hp_pengantar,alamat_pengantar,keterangan,hubungan_dengan_pasien,dokter,hp_pasien,id_dokter,level_harga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_regisrasi->bind_param("sssssssssssssssssssssssssssssss",urldecode($eye),urldecode($verbal),urldecode($motorik),urldecode($alergi),urldecode($nama_lengkap),urldecode($jam),urldecode($penjamin),$sig_in_ugd,urldecode($no_reg),urldecode($no_rm),urldecode($tanggal_sekarang),urldecode($kondisi),urldecode($username),urldecode($alamat_ktp),urldecode($umur),urldecode($jenis_kelamin),urldecode($rujukan),$ugd_ku,urldecode($gol_darah),urldecode($status_kawin),urldecode($pekerjaan_pasien),urldecode($pengantar),urldecode($nama_pengantar),urldecode($hp_pengantar),urldecode($alamat_pengantar),urldecode($keterangan),urldecode($hubungan_dengan_pasien),urldecode($dokter_jaga),urldecode($no_telepon),urldecode($id_dokter_jaga),urldecode($level_harga));

    $sig_in_ugd = urldecode('Masuk Ruang UGD');
    $ugd_ku = urldecode('UGD');

  $query_insert_regisrasi->execute();

// INSERT KE REKAM MEDIK
  $query_insert_rekam_medik = $db->prepare("INSERT INTO rekam_medik_ugd (tanggal,jam,no_reg,no_rm,nama,jenis_kelamin,umur,alamat,eye,verbal,motorik,rujukan,pengantar,alergi,keadaan_umum,dokter,petugas) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_rekam_medik->bind_param("sssssssssssssssss", $tanggal_sekarang,$jam,$no_reg,$no_rm,$nama_lengkap,$jenis_kelamin,$umur,$alamat_sekarang,$eye,$verbal, $motorik,$rujukan,$pengantar,$alergi,$kondisi,$dokter_jaga,$username);

  $query_insert_rekam_medik->execute();

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