<?php session_start();
include 'db.php';
include_once 'sanitasi.php';

$token = stringdoang($_POST['token']);


if ($token == '')
{
   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else
{

$username = stringdoang($_SESSION['nama']);
$umur = stringdoang($_POST['umur']);
$no_rm = stringdoang($_POST['no_rm']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$umur = stringdoang($_POST['umur']);
$hp_pasien = stringdoang($_POST['hp_pasien']);
$kondisi = stringdoang($_POST['kondisi']);
$penjamin = stringdoang($_POST['penjamin']);
if ($penjamin == '')
{
  $penjamin = 'PERSONAL';
}
$surat_jaminan = stringdoang($_POST['surat_jaminan']);
$perkiraan_menginap = stringdoang($_POST['perkiraan_menginap']);
$penanggung_jawab = stringdoang($_POST['penanggung_jawab']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$pekerjaan = stringdoang($_POST['pekerjaan_penanggung']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);
$bed = stringdoang($_POST['bed']);
$poli = stringdoang($_POST['poli']);
$dokter_pengirim = stringdoang($_POST['dokter_pengirim']);
$group_bed = stringdoang($_POST['group_bed']);
$tinggi_badan = stringdoang($_POST['tinggi_badan']);
$berat_badan = stringdoang($_POST['berat_badan']);
$suhu = stringdoang($_POST['suhu']);
$nadi = stringdoang($_POST['nadi']);
$respiratory_rate = stringdoang($_POST['respiratory_rate']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$perujuk = stringdoang($_POST['rujukan']);
$alergi = stringdoang($_POST['alergi']);
$no_reg = stringdoang($_POST['no_reg']);


$session_id = session_id();



$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");

$no_urut = 1;
$bulan_php = date("m");
$tahun_php = date("Y");

$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'BED'");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];

$select_to = $db->query("SELECT nama_pasien FROM registrasi WHERE jenis_pasien = 'Rawat Inap' ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap)
{
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';
}
else{


$select_to_me = $db->query("SELECT jenis_pasien FROM registrasi WHERE no_reg = '$no_reg' ");
$out_me = mysqli_fetch_array($select_to_me);

// untuk hapus rekam medik yang sebelumnya
if ($out_me['jenis_pasien'] == 'Rawat Jalan')
{
  $delete_to_one = $db->query("DELETE FROM rekam_medik WHERE no_reg = '$no_reg'");
}

elseif ($out_me['jenis_pasien'] == 'UGD')

{
  $delete_to = $db->query("DELETE FROM rekam_medik_ugd WHERE no_reg = '$no_reg'");
}

// akhir hapus rekam medik sebelumnya


$update_to = "UPDATE registrasi SET alergi = '$alergi', rujukan = '$perujuk',nama_pasien = '$nama_lengkap',
 jam = '$jam', penjamin = '$penjamin', status = 'menginap', no_reg = '$no_reg', no_rm = '$no_rm', 
 tanggal_masuk = '$tanggal_sekarang', kondisi = '$kondisi', petugas ='$username', alamat_pasien = '$alamat', 
 umur_pasien = '$umur',hp_pasien = '$hp_pasien', bed = '$bed', group_bed = '$group_bed', menginap = '$perkiraan_menginap', dokter = '$dokter_penanggung_jawab',dokter_pengirim = '$dokter_pengirim', penanggung_jawab = '$penanggung_jawab',
  alamat_penanggung_jawab = '$alamat_penanggung', hp_penanggung_jawab = '$no_hp_penanggung',
  pekerjaan_penanggung_jawab = '$pekerjaan', hubungan_dengan_pasien = '$hubungan_dengan_pasien', 
  jenis_kelamin = '$jenis_kelamin' ,poli = '$poli' ,jenis_pasien = 'Rawat Inap',
  tanggal = '$tanggal_sekarang' WHERE no_reg = '$no_reg'";
if ($db->query($update_to) == TRUE) {
} else {
    echo "Error: " . $update_to . "<br>" . $db->error;
}




$sql0 ="INSERT INTO rekam_medik_inap
(group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,
respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed)
VALUES 
('$group_bed','$alergi','$no_reg','$no_rm','$nama_lengkap','$alamat','$umur','$jenis_kelamin','$sistole_distole',
'$suhu','$berat_badan','$tinggi_badan','$nadi','$respiratory_rate','$poli','$tanggal_sekarang','$jam',
'$dokter_pengirim','$kondisi','$perujuk','$dokter_penanggung_jawab','$bed')";

if ($db->query($sql0) == TRUE) 
  {
  } 
else 
{
  echo "Error: " . $sql0 . "<br>" . $db->error;
}


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET pekerjaan_suamiortu = '$pekerjaan', no_hp_penanggung = '$no_hp_penanggung', hubungan_dengan_pasien = '$hubungan_dengan_pasien', alamat_penanggung = '$alamat_penanggung', nama_penanggungjawab = '$penanggung_jawab', umur = '$umur', no_telp = '$hp_pasien', alamat_sekarang = '$alamat', penjamin = '$penjamin' WHERE kode_pelanggan = '$no_rm'";
if ($db->query($update_pasien) === TRUE) 
  {
} 
else 
    {
    echo "Error: " . $update_pasien . "<br>" . $db->error;
    } 

$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");



  
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


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar1','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
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


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar2','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
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


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar3','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
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


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar4','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
        
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
// harga_4 (pertama)

else if ($level_harga == 'harga_5')
{

$subtotal = $perkiraan_menginap * $harga_kamar5;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar5','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_5 (pertama)

else if ($level_harga == 'harga_6')
{

$subtotal = $perkiraan_menginap * $harga_kamar6;


$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar6','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_6 (pertama)


else if ($level_harga == 'harga_7')
{

$subtotal = $perkiraan_menginap * $harga_kamar7;

$query65 = "INSERT INTO tbs_penjualan (session_id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,satuan,jam,tanggal) VALUES ('$session_id','$no_reg','$bed','$group_bed','$perkiraan_menginap','$harga_kamar7','$subtotal','Bed','0','0','$satuan_bed','$jam','$tanggal_sekarang')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }

}
// harga_7 (pertama)

// biar gk double 
} // token
}


 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rawat_inap.php">';

?>

 