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
if ($penjamin == '')
{
  $penjamin = 'PERSONAL';
}
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
header('location:rawat_jalan_lama.php');
}
else{

$ambil_rm = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan != 0 ORDER BY id DESC LIMIT 1 ");
$no_ter = mysqli_fetch_array($ambil_rm);
ECHO $no_rm = $no_ter['kode_pelanggan'] + 1;


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

 else
 {

$nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA



$query80 = $db->query("SELECT * FROM registrasi WHERE tanggal = '$tanggal_sekarang' AND poli = '$poli' ORDER BY no_urut DESC LIMIT 1 ");
$jumlah = mysqli_num_rows($query80);
$data = mysqli_fetch_array($query80);

if($jumlah > 0 )
{

$no_urut_terakhir = $no_urut + $data['no_urut'];  

// masukin ke registrasi


$stmt = $db->prepare("INSERT INTO registrasi 
  (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,
  no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,
  gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien) 
  VALUES
  (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
 $stmt->bind_param("ssssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$poli,$no_urut_terakhir,
  $nama_lengkap,$jam,$penjamin,$dokter,$menunggu,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_ktp,$umur,$jenis_kelamin,$rujukan, $rawat_jalan_nya,$gol_darah,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$status_kawin,$pekerjaan_pasien);

$menunggu = 'menunggu';
$rawat_jalan_nya = 'Rawat Jalan';


 $stmt->execute();




// masukin ke DB PASIEN

      if ($no_rm_lama != '' ){

         $delete_one = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");

      

      $sql91 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
        tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,
        nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,
        alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,
        status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama)
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

      $sql91->bind_param("ssssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);

      $sql91->execute();

     

      }//if ($no_rm_lama != '' )

     else//if ($no_rm_lama != '' )
     {

    $sql9 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
      tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,
      nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,
      alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,
      status_kawin,agama,penjamin,gol_darah,tanggal)
       VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $sql9->bind_param("sssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang);

    $sql9->execute();


    }// else//if ($no_rm_lama != '' )

}//end if($jumlah > 0 )

else // else if > 0
{
$sql7 = $db->prepare("INSERT INTO registrasi 
  (alergi,no_kk,nama_kk,poli,no_urut,nama_pasien,jam,penjamin,dokter,status,
  no_reg,no_rm,tanggal,kondisi,petugas,alamat_pasien,umur_pasien,jenis_kelamin,rujukan,jenis_pasien,
  gol_darah,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,status_nikah,pekerjaan_pasien) 
  VALUES
  (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
 $sql7->bind_param("ssssssssssssssssssssssssss", $alergi,$no_kk,$nama_kk,$poli,$no_urut,
  $nama_lengkap,$jam,$penjamin,$dokter,$menunggu2,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat_ktp,$umur,$jenis_kelamin,$rujukan,
 $rawat_jalan_nya2,$gol_darah,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$status_kawin,$pekerjaan_pasien);


$menunggu2 = 'menunggu';
$rawat_jalan_nya2 = 'Rawat Jalan';


 $sql7->execute();


// MASUKIN KE DB PASIEN



if ($no_rm_lama != ''){

$sql9991 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,  nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien, alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,status_kawin,agama,penjamin,gol_darah,tanggal,no_rm_lama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql9991->bind_param("ssssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang,$no_rm_lama);

$sql9991->execute();

$delete_one1 = $db_pasien->query("DELETE FROM pelanggan WHERE no_rm_lama = '$no_rm_lama' AND (kode_pelanggan IS NULL OR kode_pelanggan = 0)  ");


}
else{

$sql5 = $db_pasien->prepare("INSERT INTO pelanggan (alergi,no_kk,nama_kk,kode_pelanggan,nama_pelanggan,
  tempat_lahir,tgl_lahir,umur,alamat_sekarang,alamat_ktp,no_telp,no_ktp,
  nama_suamiortu,pekerjaan_suamiortu,nama_penanggungjawab,hubungan_dengan_pasien,
  alamat_penanggung,no_hp_penanggung,jenis_kelamin,pendidikan_terakhir,
  status_kawin,agama,penjamin,gol_darah,tanggal)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql5->bind_param("sssssssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_rm,$nama_lengkap,$tempat_lahir,$tanggal_lahir,$umur,$alamat_sekarang,$alamat_ktp,$no_telepon,$no_ktp,$nama_suamiortu,$pekerjaan_pasien,$nama_penanggungjawab,$hubungan_dengan_pasien,$alamat_penanggung,$no_hp_penanggung,$jenis_kelamin,$pendidikan_terakhir,$status_kawin,$agama,$penjamin,$gol_darah,$tanggal_sekarang);

$sql5->execute();


}


}

// masukin ke rekam medik 




$sql0 = $db->prepare("INSERT INTO rekam_medik
 (alergi,no_kk,nama_kk,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,
  nadi,respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql0->bind_param("sssssssssssssssssssss",$alergi,$no_kk,$nama_kk,$no_reg,$no_rm,$nama_lengkap,$alamat_sekarang,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter,$kondisi,$rujukan);


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