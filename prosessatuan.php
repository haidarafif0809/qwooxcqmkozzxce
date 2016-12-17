<?php 

include 'db.php';
include 'sanitasi.php';


//masukan data ke database satuan
$perintah = $db->prepare("INSERT INTO satuan (nama,nama_cetak,dari_satuan,qty)
			VALUES (?,?,?,?)");

$perintah->bind_param("sssi",
	$nama,$nama_cetak,$satuan,$qty);

	
	$nama = stringdoang($_POST['nama']);
	$nama_cetak = stringdoang($_POST['nama_cetak']);
	$satuan = stringdoang($_POST['satuan']);
	$qty = stringdoang($_POST['qty']);

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