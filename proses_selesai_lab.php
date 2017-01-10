<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);
$no_rm = stringdoang($_POST['no_rm']);
echo $no_reg = stringdoang($_POST['no_reg']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);

$select = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");
while($out = mysqli_fetch_array($select))
{
	$input = $db->query("INSERT INTO hasil_lab (id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_abnormal, status_pasien, status, no_rm, no_reg, nama_pasien) VALUES ('$out[id_pemeriksaan]',
		'$out[nama_pemeriksaan]','$out[hasil_pemeriksaan]','$out[nilai_normal_lk]','$out[nilai_normal_pr]',
		'$out[status_abnormal]','$jenis_penjualan','Selesai','$no_rm','$no_reg','$nama')");

	  if ($db->query($input) === TRUE)
      {
      } 
      else 
      { 
     
      }

}

$delete = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");


?>