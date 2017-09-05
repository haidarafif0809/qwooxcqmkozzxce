<?php include 'session_login.php';
      include 'db.php';
      include_once 'sanitasi.php';

  $token = stringdoang(urlencode($_POST['token']));
  $session_id = session_id();

  $query_setting_registerasi = $db->query("SELECT tampil_data_pasien_umum, tampil_ttv FROM setting_registrasi");
  $data_setting_registerasi = mysqli_fetch_array($query_setting_registerasi);

// start data agar tetap masuk 
try {
// First of all, let's begin a transaction
  $db->begin_transaction();
// A set of queries; if one fails, an exception should be thrown
// begin data

if ($token == ''){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{

  $username = $_SESSION['nama'];

  $no_rm_lama = stringdoang(urlencode($_POST['no_rm_lama']));
  $nama_lengkap = stringdoang(urlencode($_POST['nama_lengkap']));
  $tempat_lahir = stringdoang(urlencode($_POST['tempat_lahir']));
  $tanggal_lahir = stringdoang(urlencode($_POST['tanggal_lahir']));
  $tanggal_lahir = tanggal_mysql($tanggal_lahir);
  $umur = stringdoang(urlencode($_POST['umur']));
  $alamat_sekarang = stringdoang(urlencode($_POST['alamat_sekarang']));
  $no_telepon = stringdoang(urlencode($_POST['no_telepon']));
  $jenis_kelamin = stringdoang(urlencode($_POST['jenis_kelamin']));
  $penjamin = stringdoang(urlencode($_POST['penjamin']));
  if ($penjamin == ''){
    $penjamin = 'PERSONAL';
  }

//JIKA KOLOM DATA PASIEN DI TAMPILKAN, SAAT REGISTRASI PASIEN BARU
if ($data_setting_registerasi['tampil_data_pasien_umum'] == 1) {

    $no_kk = stringdoang(urlencode($_POST['no_kk']));
    $nama_kk = stringdoang(urlencode($_POST['nama_kk']));
    $no_ktp = stringdoang(urlencode($_POST['no_ktp']));
    $alamat_ktp = stringdoang(urlencode($_POST['alamat_ktp']));
    $status_kawin = stringdoang(urlencode($_POST['status_kawin']));
    $pendidikan_terakhir = stringdoang(urlencode($_POST['pendidikan_terakhir']));
    $agama = stringdoang(urlencode($_POST['agama']));
    $pekerjaan_penanggung = stringdoang(urlencode($_POST['pekerjaan_penanggung']));
    $nama_penanggungjawab = stringdoang(urlencode($_POST['nama_penanggungjawab']));
    $hubungan_dengan_pasien = stringdoang(urlencode($_POST['hubungan_dengan_pasien']));
    $no_hp_penanggung = stringdoang(urlencode($_POST['no_hp_penanggung']));
    $alamat_penanggung = stringdoang(urlencode($_POST['alamat_penanggung']));

}
else{

    $no_kk = "";
    $nama_kk = "";
    $no_ktp = "";
    $alamat_ktp = "";
    $status_kawin = "";
    $pendidikan_terakhir = "";
    $agama = "";
    $pekerjaan_penanggung = "";
    $nama_penanggungjawab = "";
    $hubungan_dengan_pasien = "";
    $no_hp_penanggung = "";
    $alamat_penanggung = "";

}

  $gol_darah = stringdoang(urlencode($_POST['gol_darah']));
  $poli = stringdoang(urlencode($_POST['poli']));
  $kondisi = stringdoang(urlencode($_POST['kondisi']));
  $rujukan = stringdoang(urlencode($_POST['rujukan']));

//JIKA KOLOM TTV DI TAMPILKAN, SAAT REGISTRASI PASIEN BARU
  if ($data_setting_registerasi['tampil_ttv'] == 1) { 

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

  $alergi = stringdoang(urlencode($_POST['alergi']));
  $group_bed = stringdoang(urlencode($_POST['group_bed']));
  $bed = stringdoang(urlencode($_POST['bed']));
  $perkiraan_menginap = angkadoang(urlencode($_POST['perkiraan_menginap']));
  $surat_jaminan = stringdoang(urlencode($_POST['surat_jaminan']));
  $dokter_pj = stringdoang(urlencode($_POST['dokter_penanggung_jawab']));
  $dokter_jg = stringdoang(urlencode($_POST['dokter']));
  $ruangan_split = stringdoang(urlencode($_POST['ruangan']));

  $dokter_jg = explode("-", $dokter_jg); 
  $id_dokter = $dokter_jg[0]; 
  $dokter = $dokter_jg[1]; 

  $dokter_pj = explode("-", $dokter_pj); 
  $id_dokter_penanggung_jawab = $dokter_pj[0]; 
  $dokter_penanggung_jawab = $dokter_pj[1]; 

  $ruangan_split = explode("-", $ruangan_split); 
  $id_ruangan = $ruangan_split[0]; 
  $ruangan = $ruangan_split[1]; 

  $query_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'HARI'")->fetch_array();
  $satuan_bed = $query_satuan['id'];

  $no_urut = 1;
  $jam =  date("H:i:s");
  $tanggal_sekarang = date("Y-m-d");
  $bulan_php = date('m');
  $tahun_php = date('Y');

$query_registrasi = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Jalan'  ORDER BY id DESC LIMIT 1 ")->fetch_array();

if ($query_registrasi['nama_pasien'] == $nama_lengkap )
{
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{



// START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// mulai hitung no reg
  $tahun_terakhir = substr($tahun_php, 2);

//ambil bulan dari tanggal penjualan terakhir
  $data_bulan_no_reg = $db->query("SELECT MONTH(tanggal) as bulan, no_reg FROM registrasi ORDER BY id DESC LIMIT 1")->fetch_array();
  $bulan_terakhir_reg = $data_bulan_no_reg['bulan'];
  $ambil_nomor = substr($data_bulan_no_reg['no_reg'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1*/
if ($bulan_terakhir_reg != $bulan_php) {
  $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;
}
else{
  $nomor = 1 + $ambil_nomor ;
  $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;
}

// Akhir ambil no reg
// ENDING — UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// ambil bahan untuk kamar 
  $query_penjamin = $db->query(" SELECT harga FROM penjamin WHERE nama = '$penjamin'")->fetch_array();
  $level_harga = $query_penjamin['harga'];

//SELECT UNTUK MENGAMBIL SETTING URL U/ DATA PASIEN BARU RI
  $data_reg_pasien = $db->query("SELECT url_data_pasien FROM setting_registrasi_pasien WHERE id = '3' ")->fetch_array();


//PROSES INPUT PASIEN KE DB ONLINE
  $url = $data_reg_pasien['url_data_pasien'];
  $data_url = $url.'?no_rm_lama='.$no_rm_lama.'&nama_lengkap='.$nama_lengkap.'&no_ktp='.$no_ktp.'&tempat_lahir='.$tempat_lahir.'&tanggal_lahir='.$tanggal_lahir.'&umur='.$umur.'&alamat_sekarang='.$alamat_sekarang.'&alamat_ktp='.$alamat_ktp.'&no_telepon='.$no_telepon.'&pekerjaan_penanggung='.$pekerjaan_penanggung.'&nama_penanggungjawab='.$nama_penanggungjawab.'&hubungan_dengan_pasien='.$hubungan_dengan_pasien.'&no_hp_penanggung='.$no_hp_penanggung.'&alamat_penanggung='.$alamat_penanggung.'&jenis_kelamin='.$jenis_kelamin.'&status_kawin='.$status_kawin.'&pendidikan_terakhir='.$pendidikan_terakhir.'&agama='.$agama.'&penjamin='.$penjamin.'&gol_darah='.$gol_darah.'&poli='.$poli.'&kondisi='.$kondisi.'&rujukan='.$rujukan.'&sistole_distole='.$sistole_distole.'&respiratory_rate='.$respiratory_rate.'&sistole_distole='.$sistole_distole.'&respiratory_rate='.$respiratory_rate.'&suhu='.$suhu.'&nadi='.$nadi.'&berat_badan='.$berat_badan.'&tinggi_badan='.$tinggi_badan.'&alergi='.$alergi.'&no_kk='.$no_kk.'&nama_kk='.$nama_kk.'&token='.$token.'&group_bed='.$group_bed.'&bed='.$bed.'&perkiraan_menginap='.$perkiraan_menginap.'&surat_jaminan='.$surat_jaminan.'&dokter='.$dokter.'&dokter_penanggung_jawab='.$dokter_penanggung_jawab.'&ruangan='.$ruangan;

  $file_get = file_get_contents($data_url);

//ambil no rm dari DB online
  $no_rm = $file_get;


// INSERT KE REGISTRASI
  $query_insert_regisrasi = $db->prepare("INSERT INTO registrasi (alergi,rujukan,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal_masuk,kondisi,petugas,alamat_pasien,umur_pasien,hp_pasien,bed,group_bed,menginap,dokter,dokter_pengirim,penanggung_jawab, alamat_penanggung_jawab,hp_penanggung_jawab,pekerjaan_penanggung_jawab,hubungan_dengan_pasien,jenis_kelamin,poli,jenis_pasien,tanggal,ruangan,nama_ruangan,id_dokter,id_dokter_pengirim,level_harga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_regisrasi->bind_param("ssssssssssssssssssssssssssssissss",urldecode($alergi),urldecode($rujukan),urldecode($nama_lengkap),urldecode($jam),urldecode($penjamin),$status,urldecode($no_reg),urldecode($no_rm),urldecode($tanggal_sekarang),urldecode($kondisi),urldecode($username),urldecode($alamat_sekarang),urldecode($umur),urldecode($no_telepon),urldecode($bed),urldecode($group_bed),urldecode($perkiraan_menginap),urldecode($dokter),urldecode($dokter_penanggung_jawab),urldecode($nama_penanggungjawab),urldecode($alamat_penanggung),urldecode($no_hp_penanggung),urldecode($pekerjaan_penanggung),urldecode($hubungan_dengan_pasien),urldecode($jenis_kelamin),urldecode($poli),$jenis_pasien,urldecode($tanggal_sekarang),urldecode($id_ruangan),urldecode($ruangan),urldecode($id_dokter),urldecode($id_dokter_penanggung_jawab),urldecode($level_harga));

    $jenis_pasien = 'Rawat Inap';
    $status = 'menginap';
  $query_insert_regisrasi->execute();

// INSERT KE REKAM MEDIK
  $query_insert_rm = $db->prepare("INSERT INTO rekam_medik_inap (group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed,ruangan,petugas) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  $query_insert_rm->bind_param("ssssssssssssssssssssssis", urldecode($group_bed),urldecode($alergi),urldecode($no_reg),urldecode($no_rm),urldecode($nama_lengkap),urldecode($alamat_sekarang),urldecode($umur),urldecode($jenis_kelamin),urldecode($sistole_distole),urldecode($suhu),urldecode($berat_badan),urldecode($tinggi_badan),urldecode($nadi),urldecode($respiratory_rate),urldecode($poli),urldecode($tanggal_sekarang),urldecode($jam),urldecode($dokter),urldecode($kondisi),urldecode($rujukan),urldecode($dokter_penanggung_jawab),urldecode($bed),urldecode($ruangan),$username);

  $query_insert_rm->execute();

// UPDATE KAMAR

  $query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '".urldecode($bed)."' AND group_bed = '".urldecode($group_bed)."'");

  $data_kamar_bed = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '".urldecode($bed)."' AND group_bed = '".urldecode($group_bed)."' ")->fetch_array();
  $harga_kamar1 = $data_kamar_bed['tarif'];
  $harga_kamar2 = $data_kamar_bed['tarif_2'];
  $harga_kamar3 = $data_kamar_bed['tarif_3'];
  $harga_kamar4 = $data_kamar_bed['tarif_4'];
  $harga_kamar5 = $data_kamar_bed['tarif_5'];
  $harga_kamar6 = $data_kamar_bed['tarif_6'];
  $harga_kamar7 = $data_kamar_bed['tarif_7'];


  // HARGA KAMAR
  if ($level_harga == 'harga_1') {
    $subtotal = $perkiraan_menginap * $harga_kamar1;
  }
  else if ($level_harga == 'harga_2') {
    $subtotal = $perkiraan_menginap * $harga_kamar2;
  }
  else if ($level_harga == 'harga_3') {
    $subtotal = $perkiraan_menginap * $harga_kamar3;
  }
  else if ($level_harga == 'harga_4') {
    $subtotal = $perkiraan_menginap * $harga_kamar4;
  }
  else if ($level_harga == 'harga_5') {
    $subtotal = $perkiraan_menginap * $harga_kamar5;
  }
  else if ($level_harga == 'harga_6') {
    $subtotal = $perkiraan_menginap * $harga_kamar6;
  }
  else {
    $subtotal = $perkiraan_menginap * $harga_kamar7;
  }


  $query_set_kamar = $db->query("SELECT proses_kamar FROM setting_kamar ");
  $data_sett_kamar  = mysqli_fetch_array($query_set_kamar);

  if ($data_sett_kamar['proses_kamar'] == 1){

    $query_insert_tbs_penjualan = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal,ruangan) VALUES ('$session_id','$no_reg','".urldecode($bed)."','".urldecode($group_bed)."','".urldecode($perkiraan_menginap)."','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang','".urldecode($ruangan)."')";
    if ($db->query($query_insert_tbs_penjualan) === TRUE) {
    }
    else {
      echo "Error: " . $query_insert_tbs_penjualan . "<br>" . $db->error;
    }

  }

} // biar gak double pasiennya
} // token

  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
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