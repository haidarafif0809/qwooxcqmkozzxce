<?php
include 'sanitasi.php';
include 'db.php';


$id = stringdoang($_POST['id']);
$prosentase = angkadecimal($_POST['jumlah_prosentase']);
$nominal = angkadoang($_POST['jumlah_uang']);


$query = $db->prepare("UPDATE fee_produk SET jumlah_prosentase = ?, jumlah_uang = ? WHERE id = ?");

$query->bind_param("sss",
	$prosentase, $nominal, $id);

$query->execute();



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }


    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>