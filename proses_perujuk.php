<?php 
include 'db.php';
include_once 'sanitasi.php';

$nama = stringdoang($_POST['nama']);
$alamat = stringdoang($_POST['alamat']);
$no_telp = stringdoang($_POST['no_telp']);

$cek = $db->query("SELECT * FROM perujuk WHERE nama='$nama' ");

$jumlah = mysqli_num_rows($cek);

if($jumlah == 0)
{
$query = $db->prepare("INSERT INTO perujuk (nama,alamat,no_telp) VALUES (?,?,?) ");



$query->bind_param("sss",$nama,$alamat,$no_telp);
$query->execute();

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=perujuk.php">';
}

else{
	echo "<h1><center>NAMA PERUJUK YANG ANDA MASUKAN SUDAH TERDAFTAR</center></h1>";
}

 ?>