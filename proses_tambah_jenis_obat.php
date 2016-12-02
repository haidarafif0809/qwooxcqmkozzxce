<?php 

include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['jenis']);

$cek = $db->query("SELECT * FROM jenis WHERE nama = '$nama' ");
$data = mysqli_num_rows($cek);

if ($data == 0 )
{

$query = $db->prepare("INSERT INTO jenis (nama) VALUES (?)");
$query->bind_param("s",$nama);
$query->execute();



echo '<META HTTP-EQUIV="Refresh" Content="0; URL=tambah_jenis_obat.php">';
}

else {

echo "<h1><center>Nama Jenis Yang Anda Masukan Sudah Ada</center></h1>";


	}

?>