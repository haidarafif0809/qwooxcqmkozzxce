<?php
include 'sanitasi.php';
include 'db.php';

$query = $db->prepare("UPDATE kelas_kamar SET nama = ? WHERE id = ?");

$query->bind_param("ss", $nama, $id);
	
	$id = stringdoang($_POST['id']);
	$nama = stringdoang($_POST['nama']);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }


    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=kelas_kamar.php">';

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>