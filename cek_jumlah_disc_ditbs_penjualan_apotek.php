<?php session_start();

include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);

$query_tbs_penjualan = $db->query("SELECT sum(potongan) as potongannya FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg IS NULL");
$data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);

echo json_encode($data_tbs_penjualan);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


