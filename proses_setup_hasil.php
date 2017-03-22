<?php 
include 'db.php';
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
$sub_hasil_lab = stringdoang($_POST['sub_hasil_lab']);
if($sub_hasil_lab == '')
{
	$sub_hasil_lab = 0;
}
$select = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE id = '$sub_hasil_lab'");
$out = mysqli_fetch_array($select);
$id_jasa = $out['nama_pemeriksaan'];

$jasa_lab = $db->query("SELECT nama FROM jasa_lab WHERE id = '$id_jasa'");
$drop = mysqli_fetch_array($jasa_lab);
$nama_sub = $drop['nama'];

if ($model_hitung == 'Numeric')
{

	$insert_to = "INSERT INTO setup_hasil (text_hasil,nama_pemeriksaan,
	kelompok_pemeriksaan,model_hitung,normal_lk,normal_pr,normal_lk2,normal_pr2,metode,kategori_index,text_reference,satuan_nilai_normal,sub_hasil_lab,
	nama_sub) VALUES ('$text_hasil','$pemeriksaan','$kelompok',
	'$perhitungan','$nilai_lk','$nilai_p','$nilai_lk2','$nilai_p2',
	'$metode','$kategori_index','$text_depan','$satuan_nilai',
	'$sub_hasil_lab','$nama_sub')";

	if ($db->query($insert_to) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_to . "<br>" . $db->error;
        }

}
else
{

	$insert_to_and = "INSERT INTO setup_hasil (text_hasil,nama_pemeriksaan,
	kelompok_pemeriksaan,model_hitung,normal_lk,normal_pr,metode,
	kategori_index,text_reference,sub_hasil_lab,nama_sub) VALUES 
	('$text_hasil','$pemeriksaan','$kelompok','Text','$text_lk','$text_p',
	'$metode','$kategori_index','$text_depan','$sub_hasil_lab','$nama_sub')";

	if ($db->query($insert_to_and) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_to_and . "<br>" . $db->error;
        }
}

echo '<script>window.location.href="setup_hasil.php";</script>';


 ?>