<?php 

include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);

//masukan data ke database satuan
$perintah = $db->prepare("INSERT INTO satuan (nama)
			VALUES (?)");

$perintah->bind_param("s",
	$nama);


$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo 'sukses';
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>