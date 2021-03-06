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

  $no_rm_lama = stringdoang(urlencode($_POST['no_rm_lama']));
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
  if ($penjamin == ''){
    $penjamin = 'PERSONAL';
  }
  $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
  $poli = stringdoang(urlencode($_POST['poli']));
  $dokter_jg = stringdoang(urlencode($_POST['dokter']));

  $dokter_jg = explode("-", $dokter_jg); 
  $id_dokter = $dokter_jg[0]; 
  $dokter = $dokter_jg[1];

  $kondisi = stringdoang(urlencode($_POST['kondisi']));
  $rujukan = stringdoang(urlencode($_POST['rujukan']));  
  $alergi = stringdoang(urlencode($_POST['alergi']));
  $no_kk = stringdoang(urlencode($_POST['no_kk']));
  $nama_kk = stringdoang(urlencode($_POST['nama_kk']));

//JIKA KOLOM TTV TIDAK DITAMPILKAN MAKA DATA YG DIKIRIM KOSONG
if ($datasett['tampil_ttv'] == 1) {
  
  $sistole_distole = stringdoang(urlencode($_POST['sistole_distole']));
  $respiratory_rate = stringdoang(urlencode($_POST['respiratory_rate']));
  $suhu = stringdoang(urlencode($_POST['suhu']));
  $nadi = stringdoang(urlencode($_POST['nadi']));
  $berat_badan = stringdoang(urlencode($_POST['berat_badan']));
  $tinggi_badan = stringdoang(urlencode($_POST['tinggi_badan']));
}
else{

  $sistole_distole = "";
  $respiratory_rate = "";
  $suhu = "";
  $nadi = "";
  $berat_badan = "";
  $tinggi_badan = "";
}

  $no_urut = 1;
  $jam =  date("H:i:s");
  $tanggal_sekarang = date("Y-m-d");
  $bulan_php = date('m');
  $tahun_php = date('Y');

  $query_registrasi = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Jalan'  ORDER BY id DESC LIMIT 1 ")->fetch_array();

if ($query_registrasi['nama_pasien'] == $nama_lengkap ){
  header('location:rawat_jalan_lama.php');
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
  $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;
}
else{
  $nomor = 1 + $ambil_nomor ;
  $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;
}

// AKHIR UNTUK NO REG
// ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

  $query_penjamin = $db->query("SELECT harga FROM penjamin WHERE nama = '$penjamin'")->fetch_array(); 
  $level_harga = $query_penjamin['harga'];

  $query_no_urut = $db->query("SELECT no_urut FROM registrasi WHERE tanggal = '$tanggal_sekarang' AND poli = '$poli' ORDER BY no_urut DESC LIMIT 1 ");
  $row_no_urut = mysqli_num_rows($query_no_urut);
  $data_no_urut = mysqli_fetch_array($query_no_urut);

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU RJ
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '1' ")->fetch_array();

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $query_setting_registrasi_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&nama_suamiortu='.$nama_suamiortu.'&pekerjaan_pasien='.$pekerjaan_pasien.'&nama_penanggungjawab='.$nama_penanggungjawab.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&no_hp_penanggung='.$no_hp_penanggung.'&alamat_penanggung='.$alamat_penanggung.'&jenis_kelamin='.$jenis_kelamin.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&penjamin='.$penjamin.'&gol_darah='.$gol_darah.'&poli='.$poli.'&dokter='.$dokter.'&kondisi='.$kondisi.'&rujukan='.$rujukan.'&sistole_distole='.$sistole_distole.'&respiratory_rate='.$respiratory_rate.'&suhu='.$suhu.'&nadi='.$nadi.'&berat_badan='.$berat_badan.'&tinggi_badan='.$tinggi_badan.'&alergi='.$alergi.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&token='.$token;

  $file_get = file_get_contents($data_url);

//ambil no rm dari DB
  $no_rm = $file_get;

if($row_no_urut > 0 ){

  $no_urut_terakhir = $no_urut + $data_no_urut['no_urut'];

// masukin ke registrasi
  $query_insert_regisrasi = $db->prepare("INSERT INTO registrasi (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien,id_dokter,level_harga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_regisrasi->bind_param("ssssssssssssssssssssssssssss",urldecode($alergi),urldecode($no_kk),urldecode($nama_kk),urldecode($poli),urldecode($no_urut_terakhir),urldecode($nama_lengkap),urldecode($jam),urldecode($penjamin),urldecode($dokter),$status,urldecode($no_reg),urldecode($no_rm),urldecode($tanggal_sekarang),urldecode($kondisi),urldecode($username),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($rujukan), $jenis_pasien,urldecode($gol_darah),urldecode($nama_penanggungjawab),urldecode($alamat_penanggung),urldecode($no_hp_penanggung),urldecode($status_kawin),urldecode($pekerjaan_pasien),urldecode($id_dokter),urldecode($level_harga));

    $status = 'menunggu';
    $jenis_pasien = urldecode('Rawat Jalan');

  $query_insert_regisrasi->execute();

}//end if($row_no_urut > 0 )
else {// else if > 0


  $query_insert_regisrasi = $db->prepare("INSERT INTO registrasi (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,
  gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien,id_dokter,level_harga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $query_insert_regisrasi->bind_param("ssssssssssssssssssssssssssss", urldecode($alergi),urldecode($no_kk),urldecode($nama_kk),urldecode($poli),urldecode($no_urut),urldecode($nama_lengkap),urldecode($jam),urldecode($penjamin),urldecode($dokter),$status,urldecode($no_reg),urldecode($no_rm),urldecode($tanggal_sekarang),urldecode($kondisi),urldecode($username),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($rujukan),$jenis_pasien,urldecode($gol_darah),urldecode($nama_penanggungjawab),urldecode($alamat_penanggung),urldecode($no_hp_penanggung),urldecode($status_kawin),urldecode($pekerjaan_pasien),urldecode($id_dokter),urldecode($level_harga));

    $status = 'menunggu';
    $jenis_pasien = urldecode('Rawat Jalan');

  $query_insert_regisrasi->execute();

}

// INSERT REKAM MEDIK 
  $query_insert_rm = $db->prepare("INSERT INTO rekam_medik (alergi,no_kk,nama_kk,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,petugas) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_rm->bind_param("ssssssssssssssssssssss",urldecode($alergi),urldecode($no_kk),urldecode($nama_kk),urldecode($no_reg),urldecode($no_rm),urldecode($nama_lengkap),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($sistole_distole),urldecode($suhu),urldecode($berat_badan),urldecode($tinggi_badan),urldecode($nadi),urldecode($respiratory_rate),urldecode($poli),urldecode($tanggal_sekarang),urldecode($jam),urldecode($dokter),urldecode($kondisi),urldecode($rujukan),$username);

  $query_insert_rm->execute();
// ENDING UNTUK AMBIL NO FAKTUR (PENJUALAN)

// Countinue data 
// If we arrive here, it means that no exception was thrown
// i.e. no query has failed, and we can commit the transaction

  } // biar gk double 
} // token
//penutup untuk cancel double klick

    $db->commit();
      echo '<META HTTP-EQUIV="Refresh" Content="0; URL=registrasi_raja.php">';
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 

mysqli_close($db);

?>