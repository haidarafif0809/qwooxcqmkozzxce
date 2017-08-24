
<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';


$token = stringdoang($_POST['token']);

$session_id = session_id();

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
else
{

$username = $_SESSION['nama'];
$ruangan = angkadoang($_POST['ruangan']);

$no_rm_lama = stringdoang($_POST['no_rm_lama']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$no_ktp = stringdoang($_POST['no_ktp']);
$tempat_lahir = stringdoang($_POST['tempat_lahir']);
$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$umur = stringdoang($_POST['umur']);
$alamat_sekarang = stringdoang($_POST['alamat_sekarang']);
$alamat_ktp = stringdoang($_POST['alamat_ktp']);
$no_telepon = stringdoang($_POST['no_telepon']);
$pekerjaan_penanggung = stringdoang($_POST['pekerjaan_penanggung']);
$nama_penanggungjawab = stringdoang($_POST['nama_penanggungjawab']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$status_kawin = stringdoang($_POST['status_kawin']);
$pendidikan_terakhir = stringdoang($_POST['pendidikan_terakhir']);
$agama = stringdoang($_POST['agama']);
$penjamin = stringdoang($_POST['penjamin']);
if ($penjamin == '')
{
  $penjamin = 'PERSONAL';
}
$gol_darah = stringdoang($_POST['gol_darah']);
$poli = stringdoang($_POST['poli']);
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
$group_bed = stringdoang($_POST['group_bed']);
$bed = stringdoang($_POST['bed']);
$perkiraan_menginap = angkadoang($_POST['perkiraan_menginap']);
$surat_jaminan = stringdoang($_POST['surat_jaminan']);
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);

$dokter_jg = stringdoang($_POST['dokter']);
$dokter_jg = explode("-", $dokter_jg); 
$id_dokter = $dokter_jg[0]; 
$dokter = $dokter_jg[1]; 

$dokter_pj = stringdoang($_POST['dokter_penanggung_jawab']);
$dokter_pj = explode("-", $dokter_pj); 
$id_dokter_penanggung_jawab = $dokter_pj[0]; 
$dokter_penanggung_jawab = $dokter_pj[1]; 


$ruangan_split = stringdoang($_POST['ruangan']);
$ruangan_split = explode("-", $ruangan_split); 
$id_ruangan = $ruangan_split[0]; 
$ruangan = $ruangan_split[1]; 


$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'HARI'");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];

$tgl = date('Y-m-d');
$no_urut = 1;
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Jalan'  ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap )
{
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{


// START NO. RM PASIEN
$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
$no_ter = mysqli_fetch_array($ambil_rm);
$no_rm = $no_ter['kode_pelanggan'] + 1;
// END NO. RM PASIEN

// START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// mulai hitung no reg 

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
 // Akhir ambil no reg
 // ENDING — UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// ambil bahan untuk kamar 
$query_penjamin = $db->query(" SELECT harga FROM penjamin WHERE nama = '$penjamin'");
$data_penjamin  = mysqli_fetch_array($query_penjamin);
$level_harga = $data_penjamin['harga'];

// insert ke registrasi
$insert_1 = $db->prepare("INSERT INTO registrasi (alergi,rujukan,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal_masuk,kondisi,petugas,alamat_pasien,umur_pasien,hp_pasien,bed,group_bed,menginap,dokter,dokter_pengirim,penanggung_jawab, alamat_penanggung_jawab,hp_penanggung_jawab,pekerjaan_penanggung_jawab,hubungan_dengan_pasien, jenis_kelamin,poli,jenis_pasien,tanggal,ruangan,nama_ruangan,id_dokter,id_dokter_pengirim,level_harga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$insert_1->bind_param("ssssssssssssssssssssssssssssissss",$alergi,$rujukan,$nama_lengkap,$jam,$penjamin,$menginap_status,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_sekarang,$umur,$no_telepon,$bed,$group_bed,$perkiraan_menginap,$dokter,$dokter_penanggung_jawab,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$pekerjaan_penanggung,$hubungan_dengan_pasien,$jenis_kelamin,$poli,$rw_inap,$tanggal_sekarang,$id_ruangan,$ruangan,$id_dokter,$id_dokter_penanggung_jawab,$level_harga);


$menginap_status = "menginap";
$rw_inap = "Rawat Inap";


$insert_1->execute();



$insert_2 = $db->prepare("INSERT INTO rekam_medik_inap
(group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed,ruangan,petugas)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$insert_2->bind_param("ssssssssssssssssssssssis", $group_bed,$alergi,$no_reg,$no_rm,$nama_lengkap,$alamat_sekarang,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter,$kondisi,$rujukan,$dokter_penanggung_jawab,$bed,$ruangan,$username);


$insert_2->execute();


// INSERT PASIEN NYA
if ($no_rm_lama != ''){


$query_insert_pelanggan = $db_pasien->prepare("INSERT INTO pelanggan(alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_penanggungjawab,hubungan_dengan_pasien,
  alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_pelanggan->bind_param("ssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);

$query_insert_pelanggan->execute();


$query_delete = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");


}

else{

$query_insert_pelanggan_lagi = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,nama_penanggungjawab,hubungan_dengan_pasien,
  alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query_insert_pelanggan_lagi->bind_param("sssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang);

$query_insert_pelanggan_lagi->execute();

}

// END UPDATE PASIEN


// UPDATE KAMAR
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");
// END UPDATE KAMAR


$query_kamar_bed = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed' AND group_bed = '$group_bed' ");
$data_kamar_bed = mysqli_fetch_array($query_kamar_bed);
$harga_kamar1 = $data_kamar_bed['tarif'];
$harga_kamar2 = $data_kamar_bed['tarif_2'];
$harga_kamar3 = $data_kamar_bed['tarif_3'];
$harga_kamar4 = $data_kamar_bed['tarif_4'];
$harga_kamar5 = $data_kamar_bed['tarif_5'];
$harga_kamar6 = $data_kamar_bed['tarif_6'];
$harga_kamar7 = $data_kamar_bed['tarif_7'];

//end bahan untuk kamar


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


$query_set_kamar = $db->query(" SELECT proses_kamar FROM setting_kamar ");
$data_sett_kamar  = mysqli_fetch_array($query_set_kamar);


if ($data_sett_kamar['proses_kamar'] == 1)
{



  $query_insert_tbs_penjualan = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal,ruangan) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang','$ruangan')";
      if ($db->query($query_insert_tbs_penjualan) === TRUE) 
      {
  
      } 
        else 
      {
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