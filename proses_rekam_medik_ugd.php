
<?php 
include 'db.php';
include_once 'sanitasi.php';

$dokter = stringdoang($_POST['dokter']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$respiratory_rate= stringdoang($_POST['respiratory_rate']);
$suhu = angkadoang($_POST['suhu']);
$umur = angkadoang($_POST['umur']);
$nadi= angkadoang($_POST['nadi']);
$berat_badan = angkadoang($_POST['berat_badan']);
$tinggi_badan  = angkadoang($_POST['tinggi_badan']);
$anamnesa = stringdoang($_POST['anamnesa']);
$pemeriksaan_fisik = stringdoang($_POST['pemeriksaan_fisik']);
$keadaan_umum = stringdoang($_POST['keadaan_umum']);
$kesadaran = stringdoang($_POST['kesadaran']);
$kondisi_keluar = stringdoang($_POST['kondisi_keluar']);
$diagnosis_utama = stringdoang($_POST['diagnosis_utama']);
$diagnosis_penyerta = stringdoang($_POST['diagnosis_penyerta']);
$diagnosis_penyerta_tambahan = stringdoang($_POST['diagnosis_penyerta_tambahan']);
$komplikasi = stringdoang($_POST['komplikasi']);
$eye = stringdoang($_POST['eye']);
$verbal = stringdoang ($_POST['verbal']);
$motorik = stringdoang($_POST['motorik']);
$alergi = stringdoang($_POST['alergi']);
$tanggal_periksa = stringdoang($_POST['tanggal_periksa']);
$jam = stringdoang($_POST['jam']);
$id = stringdoang($_POST['id']);

$query = $db->prepare("UPDATE rekam_medik_ugd SET tinggi_badan = ?, berat_badan = ?, respiratory = ?, suhu = ?, nadi = ? , sistole_distole = ?, eye = ?, verbal = ?, motorik = ?, alergi = ?, anamnesa =  ?, pemeriksaan_fisik = ?, keadaan_umum = ? ,kondisi_keluar = ? ,kesadaran = ?,icd_utama = ?,icd_penyerta = ?, icd_penyerta_tambahan = ? ,icd_komplikasi = ? , jam = ? ,tanggal = ? WHERE no_reg = ? ");


// hubungkan "data" dengan prepared statements
$query->bind_param("iisiisssssssssssssssss",$tinggi_badan,$berat_badan,$respiratory_rate,$suhu,$nadi,$sistole_distole,$eye,$verbal,$motorik,$alergi,
	$anamnesa,$pemeriksaan_fisik,$keadaan_umum,$kondisi_keluar,$kesadaran,$diagnosis_utama,$diagnosis_penyerta,$diagnosis_penyerta_tambahan,$komplikasi,$jam,$tanggal,$no_reg);

// jalankan query
$query->execute();
 
// cek query
if (!$query) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
   
}
else {

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=obat_ugd.php?reg='.$no_reg.'&tgl='.$tanggal_periksa.'&jam='.$jam.'&id='.$id.'">';
}
 
// tutup statements
$query->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
     

 ?>