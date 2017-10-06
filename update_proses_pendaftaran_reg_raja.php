<?php include 'session_login.php'; 
include 'db.php';
include_once 'sanitasi.php';

$token = stringdoang(urlencode($_POST['token']));
$settt = $db->query("SELECT tampil_ttv FROM setting_registrasi");
$datasett = mysqli_fetch_array($settt);

// start data agar tetap masuk 
try {
// First of all, let's begin a transaction
  $db->begin_transaction();

// A set of queries; if one fails, an exception should be thrown
// begin data
if ($token == ''){  
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_raja.php">';
}
else{
  $username = $_SESSION['nama'];

  $no_rm = stringdoang(urlencode($_POST['no_rm_lama']));
  $no_reg = stringdoang(urlencode($_POST['no_reg']));
  $nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
  $no_ktp = stringdoang(urlencode($_POST['no_ktp']));
  $tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
  $tanggal_lahir = stringdoang(urlencode($_POST['tanggal_lahir']));
  $tanggal_lahir = tanggal_mysql($tanggal_lahir);
  $umur = stringdoang(urlencode($_POST['umur']));
  $alamat_sekarang = stringdoang(urlencode($_POST['alamat_sekarang']));
  $alamat_ktp = stringdoang(urlencode($_POST['alamat_ktp']));
  $no_telepon = stringdoang(urlencode($_POST['no_telepon']));
  $nama_suamiortu = stringdoang(urlencode($_POST['nama_suamiortu']));
  $pekerjaan_pasien = stringdoang(urlencode($_POST['pekerjaan_pasien']));
  $nama_penanggungjawab = stringdoang(urlencode($_POST['nama_penanggungjawab']));
  $hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
  $no_hp_penanggung = stringdoang(urlencode($_POST['no_hp_penanggung']));
  $alamat_penanggung = stringdoang(urlencode($_POST['alamat_penanggung']));
  $jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
  $status_kawin = stringdoang(urlencode($_POST['status_kawin']));
  $pendidikan_terakhir = stringdoang(urlencode($_POST['pendidikan_terakhir']));
  $agama = stringdoang(urlencode($_POST['agama']));
  $penjamin = stringdoang(urlencode($_POST['penjamin']));
  $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
  $poli = stringdoang(urlencode($_POST['poli']));
  $dokter = stringdoang(urlencode($_POST['dokter']));
  $kondisi = stringdoang(urlencode($_POST['kondisi']));
  $rujukan = stringdoang(urlencode($_POST['rujukan']));

  if ($datasett['tampil_ttv'] == 1) {
      $sistole_distole = stringdoang(urlencode($_POST['sistole_distole']));
      $respiratory_rate = stringdoang(urlencode($_POST['respiratory_rate']));
      $suhu = stringdoang(urlencode($_POST['suhu']));
      $nadi = stringdoang(urlencode($_POST['nadi']));
      $berat_badan = stringdoang(urlencode($_POST['berat_badan']));
      $tinggi_badan = stringdoang(urlencode($_POST['tinggi_badan']));  }
  else{
      $sistole_distole = "";
      $respiratory_rate = "";
      $suhu = "";
      $nadi = "";
      $berat_badan = "";
      $tinggi_badan = "";
  }

  $alergi = stringdoang(urlencode($_POST['alergi']));
  $no_kk = stringdoang(urlencode($_POST['no_kk']));
  $nama_kk = stringdoang(urlencode($_POST['nama_kk']));
  $no_urut = stringdoang(urlencode($_POST['no_urut']));
  $status_registrasi = stringdoang(urlencode($_POST['status_pasien']));

  $jam =  date("H:i:s");
  $tanggal_sekarang = date("Y-m-d");
  $waktu = date("Y-m-d H:i:s");

  if ($status_registrasi == 'pasien_masuk'){
    $menunggu = 'Proses';
  }
  else{
    $menunggu = 'menunggu';
  }

  $rawat_jalan_nya = urlencode('Rawat Jalan');
   
  $query_update_reg = $db->query("UPDATE registrasi SET alergi = '".urldecode($alergi)."', no_kk = '".urldecode($no_kk)."', nama_kk = '".urldecode($nama_kk)."', poli = '".urldecode($poli)."', no_urut = '".urldecode($no_urut)."', nama_pasien = '".urldecode($nama_lengkap)."', jam = '$jam', penjamin = '".urldecode($penjamin)."', dokter = '".urldecode($dokter)."', status = '$menunggu', no_reg = '".urldecode($no_reg)."', no_rm = '".urldecode($no_rm)."', tanggal = '$tanggal_sekarang', kondisi = '".urldecode($kondisi)."', petugas = '".urldecode($username)."', alamat_pasien = '".urldecode($alamat_ktp)."', umur_pasien = '".urldecode($umur)."', jenis_kelamin = '".urldecode($jenis_kelamin)."', rujukan = '".urldecode($rujukan)."', jenis_pasien = '".urldecode($rawat_jalan_nya)."', gol_darah = '".urldecode($gol_darah)."', penanggung_jawab = '".urldecode($nama_penanggungjawab)."', alamat_penanggung_jawab = '".urldecode($alamat_penanggung)."', hp_penanggung_jawab = '".urldecode($no_hp_penanggung)."', status_nikah = '".urldecode($status_kawin)."', pekerjaan_pasien = '".urldecode($pekerjaan_pasien)."' WHERE no_reg = '".urldecode($no_reg)."' ");

// masukin ke rekam medik 


// insert rekam medik 
  $hapus_rekam_medik = $db->query("DELETE FROM rekam_medik WHERE no_reg = '".urldecode($no_reg)."'");

  $query_insert_rm = $db->prepare("INSERT INTO rekam_medik(alergi,no_kk,nama_kk,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,
    nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $query_insert_rm->bind_param("sssssssssssssssssssss",urldecode($alergi),urldecode($no_kk),urldecode($nama_kk),urldecode($no_reg),urldecode($no_rm),urldecode($nama_lengkap),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($sistole_distole),urldecode($suhu),urldecode($berat_badan),urldecode($tinggi_badan),urldecode($nadi),urldecode($respiratory_rate),urldecode($poli),$tanggal_sekarang,$jam,urldecode($dokter),urldecode($kondisi),urldecode($rujukan));

  $query_insert_rm->execute();
  //insert rekam medik

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU RJ
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '7' ")->fetch_array();


//PROSES UPDATE PASIEN KE DB ONLINE
  $url = $query_setting_registrasi_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm='.$no_rm.'&nama_lengkap='.$nama_lengkap.'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&status_kawin='.$status_kawin.'&agama='.$agama.'&penjamin='.$penjamin;

  $file_get = file_get_contents($data_url);


} // token
//penutup untuk cancel double klick

  $db->commit();
  if ($status_registrasi == 'pasien_masuk'){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pasien_sudah_masuk.php">';
  }
  else{
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