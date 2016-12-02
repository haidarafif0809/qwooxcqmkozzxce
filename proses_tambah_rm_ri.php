<?php 
include 'db.php';
include 'sanitasi.php';

$poli = stringdoang($_POST['poli']);
$dokter = stringdoang($_POST['dokter']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$respiratory_rate= stringdoang($_POST['respiratory_rate']);
$suhu = angkadoang($_POST['suhu']);
$umur = stringdoang($_POST['umur']);
$nadi= angkadoang($_POST['nadi']);
$kondisi_awal = stringdoang($_POST['kondisi']);
$rujukan = stringdoang($_POST['$rujukan']);
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
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);
$bed = stringdoang($_POST['bed']);
$alergi = stringdoang($_POST['alergi']);
$group_bed = stringdoang($_POST['group_bed']);

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");

$query = $db->prepare("INSERT INTO rekam_medik_inap (no_reg
	,no_rm
	,nama
	,alamat
	,umur
	,jenis_kelamin
	,sistole_distole
	,suhu
	,berat_badan
	,tinggi_badan
	,nadi
	,respiratory
	,poli
	,anamnesa
	,dokter
	,kondisi
	,rujukan
	,pemeriksaan_fisik
	,keadaan_umum
	,kondisi_keluar
	,kesadaran
	,dokter_penanggung_jawab
	,icd_utama
	,icd_penyerta
	,icd_penyerta_tambahan
	,icd_komplikasi
	,bed
	,jam
	,tanggal_periksa
	,group_bed
	,alergi
) VALUES(?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?)");

$query->bind_param("ssssssiiiisssssssssssssssssssss",
$no_reg,
$no_rm,
$nama,
$alamat,
$umur,
$jenis_kelamin,
$sistole_distole,
$suhu,
$berat_badan,
$tinggi_badan,
$nadi,
$respiratory_rate,
$poli,
$anamnesa,
$dokter,
$kondisi_awal,
$rujukan,
$pemeriksaan_fisik,
$keadaan_umum,
$kondisi_keluar,
$kesadaran,
$dokter_penanggung_jawab,
$diagnosis_utama,
$diagnosis_penyerta,
$diagnosis_penyerta_tambahan,
$komplikasi,
$bed,
$jam,
$tanggal_sekarang,
$group_bed,
$alergi);

$query->execute();

if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekam_medik_ranap.php">';
    }
 ?>