<?php session_start();

include 'sanitasi.php';
include 'db.php';

	$no_reg = stringdoang($_GET['no_reg']);

$querytbs = $db->query("SELECT sum(potongan) as potongane FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$idtbs = mysqli_fetch_array($querytbs);


echo $idtbs['potongane'];

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


