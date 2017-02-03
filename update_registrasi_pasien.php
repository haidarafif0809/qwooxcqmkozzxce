<?php session_start();

include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_GET['no_rm']);

$abcd = $db->query("SELECT poli,penjamin FROM registrasi WHERE no_rm = '$no_rm' ORDER BY id DESC LIMIT 1 ");
$data = mysqli_fetch_array($abcd);

 echo json_encode($data);       
 //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);

 ?>


