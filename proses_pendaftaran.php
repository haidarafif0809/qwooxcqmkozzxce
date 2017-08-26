<?php include 'session_login.php'; 
include 'db.php';
include_once 'sanitasi.php';

$token = stringdoang(urlencode($_POST['token']));

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
$sistole_distole = stringdoang(urlencode($_POST['sistole_distole']));
$respiratory_rate = stringdoang(urlencode($_POST['respiratory_rate']));
$suhu = stringdoang(urlencode($_POST['suhu']));
$nadi = stringdoang(urlencode($_POST['nadi']));
$berat_badan = stringdoang(urlencode($_POST['berat_badan']));
$tinggi_badan = stringdoang(urlencode($_POST['tinggi_badan']));
$alergi = stringdoang(urlencode($_POST['alergi']));
$no_kk = stringdoang(urlencode($_POST['no_kk']));
$nama_kk = stringdoang(urlencode($_POST['nama_kk']));

$no_urut = 1;
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Jalan'  ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap ){
header('location:rawat_jalan_lama.php');
}
else{
$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
$no_ter = mysqli_fetch_array($ambil_rm);
$no_rm = $no_ter['kode_pelanggan'] + 1;


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

  $query_penjamin = $db->query("SELECT harga FROM penjamin WHERE nama = '$penjamin'"); 
  $data_penjamin  = mysqli_fetch_array($query_penjamin); 
  $level_harga = $data_penjamin['harga']; 

  $query80 = $db->query("SELECT * FROM registrasi WHERE tanggal = '$tanggal_sekarang' AND poli = '$poli' ORDER BY no_urut DESC LIMIT 1 ");
  $jumlah = mysqli_num_rows($query80);
  $data = mysqli_fetch_array($query80);

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU RJ
  $query_setting_registrasi_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '1' ");
  $data_reg_pasien = mysqli_fetch_array($query_setting_registrasi_pasien );

if($jumlah > 0 ){

  $no_urut_terakhir = $no_urut + $data['no_urut'];  

// masukin ke registrasi
  $stmt = $db->prepare("INSERT INTO registrasi 
    (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien,id_dokter,level_harga) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("ssssssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$poli,$no_urut_terakhir,$nama_lengkap,$jam,$penjamin,$dokter,$menunggu,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_sekarang,$umur,$jenis_kelamin,$rujukan, $rawat_jalan_nya,$gol_darah,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$status_kawin,$pekerjaan_pasien,$id_dokter,$level_harga);

  $menunggu = 'menunggu';
  $rawat_jalan_nya = 'Rawat Jalan';

  $stmt->execute();

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&nama_suamiortu='.$nama_suamiortu.'&pekerjaan_pasien='.$pekerjaan_pasien.'&nama_penanggungjawab='.$nama_penanggungjawab.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&no_hp_penanggung='.$no_hp_penanggung.'&alamat_penanggung='.$alamat_penanggung.'&jenis_kelamin='.$jenis_kelamin.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&penjamin='.$penjamin.'&gol_darah='.$gol_darah.'&poli='.$poli.'&dokter='.$dokter.'&kondisi='.$kondisi.'&rujukan='.$rujukan.'&sistole_distole='.$sistole_distole.'&respiratory_rate='.$respiratory_rate.'&suhu='.$suhu.'&nadi='.$nadi.'&berat_badan='.$berat_badan.'&tinggi_badan='.$tinggi_badan.'&alergi='.$alergi.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&token='.$token;

  $file_get = file_get_contents($data_url);

}//end if($jumlah > 0 )

else {// else if > 0
  $sql7 = $db->prepare("INSERT INTO registrasi (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,
  gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien,id_dokter,level_harga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $sql7->bind_param("ssssssssssssssssssssssssssss", $alergi,$no_kk,$nama_kk,$poli,$no_urut,$nama_lengkap,$jam,$penjamin,$dokter,$menunggu2,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_sekarang,$umur,$jenis_kelamin,$rujukan,$rawat_jalan_nya2,$gol_darah,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$status_kawin,$pekerjaan_pasien,$id_dokter,$level_harga);

  $menunggu2 = 'menunggu';
  $rawat_jalan_nya2 = 'Rawat Jalan';

 $sql7->execute();

//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&nama_suamiortu='.$nama_suamiortu.'&pekerjaan_pasien='.$pekerjaan_pasien.'&nama_penanggungjawab='.$nama_penanggungjawab.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&no_hp_penanggung='.$no_hp_penanggung.'&alamat_penanggung='.$alamat_penanggung.'&jenis_kelamin='.$jenis_kelamin.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&penjamin='.$penjamin.'&gol_darah='.$gol_darah.'&poli='.$poli.'&dokter='.$dokter.'&kondisi='.$kondisi.'&rujukan='.$rujukan.'&sistole_distole='.$sistole_distole.'&respiratory_rate='.$respiratory_rate.'&suhu='.$suhu.'&nadi='.$nadi.'&berat_badan='.$berat_badan.'&tinggi_badan='.$tinggi_badan.'&alergi='.$alergi.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&token='.$token;

  $file_get = file_get_contents($data_url);
}

// masukin ke rekam medik 
  $sql0 = $db->prepare("INSERT INTO rekam_medik
   (alergi,no_kk,nama_kk,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,
    nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,petugas)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $sql0->bind_param("ssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_reg,$no_rm,$nama_lengkap,$alamat_sekarang,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter,$kondisi,$rujukan,$username);

  $sql0->execute();

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