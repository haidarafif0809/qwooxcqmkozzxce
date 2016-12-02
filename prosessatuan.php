<?php 

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	//mengirim data sesuai dengan variabel dengan metode POST


// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO satuan (nama)
			VALUES (?)");

$perintah->bind_param("s",
	$nama);

	
	$nama = stringdoang($_POST['nama']);

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