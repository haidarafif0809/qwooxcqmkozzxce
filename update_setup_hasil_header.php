<?php include 'db.php';
include 'sanitasi.php';


$kelompok = stringdoang($_POST['kelompok']);
$pemeriksaan = stringdoang($_POST['pemeriksaan']);
$text_hasil = stringdoang($_POST['text_hasil']);
$metode = stringdoang($_POST['metode']);
$model_hitung = stringdoang($_POST['model_hitung']);
$perhitungan = stringdoang($_POST['perhitungan']);
$text_depan = stringdoang($_POST['text_depan']);
$satuan_nilai = stringdoang($_POST['satuan_nilai']);
$nilai_lk = stringdoang($_POST['nilai_lk']);
$nilai_lk2 = stringdoang($_POST['nilai_lk2']);
$text_lk = stringdoang($_POST['text_lk']);
$nilai_p = stringdoang($_POST['nilai_p']);
$nilai_p2 = stringdoang($_POST['nilai_p2']);
$text_p = stringdoang($_POST['text_p']);
$kategori_index = stringdoang($_POST['kategori_index']);
$id = stringdoang($_POST['id']);
$sub_hasil_lab = stringdoang($_POST['sub_hasil_lab']);



$jasa_lab = $db->query("SELECT nama FROM jasa_lab WHERE id = '$pemeriksaan'");
$drop = mysqli_fetch_array($jasa_lab);
 $nama_sub = $drop['nama'];

$update_nama_sub = $db->query("UPDATE setup_hasil SET nama_sub = '$drop[nama]' WHERE sub_hasil_lab = '$id' AND kategori_index = 'Detail'");

if ($model_hitung == 'Numeric')
{

$insert_to = $db->query("UPDATE setup_hasil SET text_hasil = '$text_hasil',
nama_pemeriksaan = '$pemeriksaan',kelompok_pemeriksaan = '$kelompok',
model_hitung = '$perhitungan', normal_lk = '$nilai_lk',
normal_pr = '$nilai_p',normal_lk2 = '$nilai_lk2',
normal_pr2 = '$nilai_p2',metode = '$metode',
kategori_index = '$kategori_index' ,text_reference = '$text_depan',
satuan_nilai_normal = '$satuan_nilai' WHERE id = '$id' ");

}
else
{
	$insert_to_and = $db->query("UPDATE setup_hasil SET text_hasil = '$text_hasil',nama_pemeriksaan = '$pemeriksaan',
		kelompok_pemeriksaan = '$kelompok' ,model_hitung = 'Text',
	normal_lk = '$text_lk' ,normal_pr = '$text_p' ,metode = '$metode' ,
	kategori_index = '$kategori_index',text_reference = '$text_depan' ,
	satuan_nilai_normal = '$satuan_nilai' WHERE id = '$id' "); 
}


echo '<script>window.location.href="setup_hasil.php";</script>';

 ?>