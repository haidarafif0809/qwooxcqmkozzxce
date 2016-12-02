<?php 
include 'db.php';
include_once 'sanitasi.php';


$dokter = stringdoang($_POST['dokter']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$rujukan = stringdoang($_POST['rujukan']);
$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$umur = stringdoang($_POST['umur']);
$eye = stringdoang($_POST['eye']);
$verbal= stringdoang($_POST['verbal']);
$motorik= stringdoang($_POST['motorik']);
$alergi  = stringdoang($_POST['alergi']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$suhu = stringdoang($_POST['suhu']);
$berat_badan = stringdoang($_POST['berat_badan']);
$anamnesa = stringdoang($_POST['anamnesa']);
$keadaan_umum = stringdoang($_POST['keadaan_umum']);
$respiratory_rate = stringdoang($_POST['respiratory_rate']);
$nadi = stringdoang($_POST['nadi']);
$tinggi_badan = stringdoang($_POST['tinggi_badan']);
$pemeriksaan_fisik = stringdoang($_POST['pemeriksaan_fisik']);
$kesadaran = stringdoang($_POST['kesadaran']);
$diagnosis_utama = stringdoang($_POST['diagnosis_utama']);
$diagnosis_penyerta = stringdoang($_POST['diagnosis_penyerta']);
$diagnosis_penyerta_tambahan = stringdoang($_POST['diagnosis_penyerta_tambahan']);
$komplikasi = stringdoang($_POST['komplikasi']);
$kondisi_keluar = stringdoang($_POST['kondisi_keluar']);

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");


$query = $db->prepare("INSERT INTO rekam_medik_ugd 
	(dokter,no_rm,no_reg,rujukan,nama,alamat,jenis_kelamin,umur,eye,verbal,motorik,alergi,sistole_distole,suhu,berat_badan,anamnesa,keadaan_umum,respiratory,nadi,tinggi_badan,pemeriksaan_fisik,kesadaran,
	icd_utama,icd_penyerta,icd_penyerta_tambahan,icd_komplikasi,kondisi_keluar,jam,tanggal) VALUES 
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query ->bind_param("sssssssssssssssssssssssssssss",$dokter,$no_rm,$no_reg,$rujukan,$nama,$alamat,$jenis_kelamin,$umur,$eye,$verbal,$motorik,$alergi,$sistole_distole,$suhu,$berat_badan,$anamnesa,$keadaan_umum,$respiratory_rate,$nadi,$tinggi_badan,$pemeriksaan_fisik,$kesadaran,$diagnosis_utama,$diagnosis_penyerta,$diagnosis_penyerta_tambahan,$komplikasi,$kondisi_keluar,$jam,$tanggal_sekarang);

$query->execute();

if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekam_medik_ugd.php">';
    }
    
 ?>
