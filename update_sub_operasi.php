<?php
include 'sanitasi.php';
include 'db.php';

$query = $db->prepare("UPDATE sub_operasi SET id_kelas_kamar = ?, id_cito = ?, harga_jual = ?
WHERE id_sub_operasi = ?");

$query->bind_param("ssis", $kelas, $cito, $harga, $sub);
	
	$kelas = stringdoang($_POST['kelas']);
	$cito = stringdoang($_POST['cito']);
    $harga = angkadoang($_POST['harga']);
	$sub = stringdoang($_POST['sub']);

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

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>