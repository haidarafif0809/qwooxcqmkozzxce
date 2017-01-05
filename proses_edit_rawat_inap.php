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
$username = $_SESSION['user_name'];
$no_rm = stringdoang($_POST['no_rm_lama']);
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
$group_bed = stringdoang($_POST['group_bed']);
$bed = stringdoang($_POST['bed']);
$perkiraan_menginap = angkadoang($_POST['perkiraan_menginap']);
$surat_jaminan = stringdoang($_POST['surat_jaminan']);
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);
$no_reg = stringdoang($_POST['no_reg']);


$group_bed_lama = stringdoang($_POST['group_bed_lama']);
$bed_lama = stringdoang($_POST['bed_lama']);


$tgl = date('Y-m-d');
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$select_to = $db->query("SELECT nama_pasien FROM registrasi  WHERE jenis_pasien = 'Rawat Inap'  ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap )
{
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{


// insert ke registrasi
$insert_1 = $db->prepare("UPDATE registrasi SET  alergi = ? ,rujukan = ? ,nama_pasien = ? ,penjamin = ? ,no_rm = ?, kondisi = ? ,petugas = ? ,alamat_pasien = ?,umur_pasien = ? ,hp_pasien = ? ,bed = ?,group_bed = ?,menginap = ? ,dokter = ? ,dokter_pengirim = ? ,penanggung_jawab = ? , alamat_penanggung_jawab = ? ,hp_penanggung_jawab = ? ,pekerjaan_penanggung_jawab = ? ,hubungan_dengan_pasien = ? ,
  jenis_kelamin = ? ,poli = ? WHERE no_reg = ? ");

$insert_1->bind_param("sssssssssssssssssssssss",$alergi,$rujukan,$nama_lengkap,$penjamin,$no_rm,$kondisi,$username,$alamat_sekarang,$umur,$no_telepon,$bed,$group_bed,$perkiraan_menginap,$dokter,$dokter_penanggung_jawab,$nama_penanggungjawab,$alamat_penanggung,$no_hp_penanggung,$pekerjaan_penanggung,$hubungan_dengan_pasien,$jenis_kelamin,$poli,$no_reg);

$insert_1->execute();


$insert_2 = $db->prepare("UPDATE rekam_medik_inap SET group_bed = ? , alergi = ? , no_rm = ? , nama = ? ,alamat = ? ,umur = ? ,jenis_kelamin = ? ,sistole_distole = ? ,suhu = ? ,berat_badan = ? ,tinggi_badan = ? ,nadi = ? ,
respiratory = ? ,poli = ? , dokter = ? ,kondisi = ? ,rujukan = ? , dokter_penanggung_jawab = ? , bed = ? WHERE no_reg = ?");

$insert_2->bind_param("ssssssssssssssssssss", $group_bed,$alergi,$no_rm,$nama_lengkap,$alamat_sekarang,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$dokter,$kondisi,$rujukan,$dokter_penanggung_jawab,$bed,$no_reg);


$insert_2->execute();


// UPDATE KAMAR
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '$bed_lama' AND group_bed = '$group_bed_lama'");
// END UPDATE KAMAR


// UPDATE KAMAR
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");
// END UPDATE KAMAR


/*
// DI NON AKTIFKAN KARENA PENAMBAHAN KAMAR NANTNYA AKAN INPUT DI TRANSAKSI PENJUALAN LANGSUNG -- DARI SINI --
// DI NON AKTIFKAN KARENA PENAMBAHAN KAMAR NANTNYA AKAN INPUT DI TRANSAKSI PENJUALAN LANGSUNG -- DARI SINI --

// ambil bahan untuk kamar 
$query20 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data20  = mysqli_fetch_array($query20);
$level_harga = $data20['harga'];

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







// harga_1 (pertama)
if ($level_harga == 'harga_1')
  {

$subtotal = $perkiraan_menginap * $harga_kamar1;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


  }
//end harga_1 (pertama)

// harga_2 (pertama)
else if ($level_harga == 'harga_2')
{

$subtotal = $perkiraan_menginap * $harga_kamar2;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar2','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
//end harga_2 (pertama)


// harga_3 (pertama)
else if ($level_harga == 'harga_3')
{

$subtotal = $perkiraan_menginap * $harga_kamar3;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar3','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_3 (pertama)

// harga_4 (pertama)
else if ($level_harga == 'harga_4')
{

$subtotal = $perkiraan_menginap * $harga_kamar4;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar4','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_ 4(pertama)

// harga_5 (pertama)
else if ($level_harga == 'harga_5')
{

$subtotal = $perkiraan_menginap * $harga_kamar5;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar5','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_5 (pertama)

// harga_6 (pertama)
else if ($level_harga == 'harga_6')
{

$subtotal = $perkiraan_menginap * $harga_kamar6;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar6','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_6 (pertama)

// harga_7 (pertama)
else if ($level_harga == 'harga_7')
{

$subtotal = $perkiraan_menginap * $harga_kamar7;


$query65 = "INSERT INTO tbs_penjualan(session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal)
 VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar7','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_7 (pertama)


 */

// DI NON AKTIFKAN KARENA PENAMBAHAN KAMAR NANTNYA AKAN INPUT DI TRANSAKSI PENJUALAN LANGSUNG -- SAMPAI SINI --
// DI NON AKTIFKAN KARENA PENAMBAHAN KAMAR NANTNYA AKAN INPUT DI TRANSAKSI PENJUALAN LANGSUNG -- SAMPAI SINI --


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