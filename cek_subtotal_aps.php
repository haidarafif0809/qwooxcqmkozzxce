<?php session_start();

include 'db.php';
include 'sanitasi.php';

$no_reg = $_POST['no_reg'];
$aps_periksa = $_POST['aps_periksa'];


if($aps_periksa == 'Laboratorium'){

$query_jumlah_harga = $db->query("SELECT SUM(harga) AS subtotal FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
$data_jumlah_harga = mysqli_fetch_array($query_jumlah_harga);
 
echo $total = $data_jumlah_harga['subtotal'];

}
else{

$query_jumlah_harga = $db->query("SELECT SUM(harga) AS subtotal FROM tbs_penjualan_radiologi WHERE  no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur IS NULL");
$data_jumlah_harga = mysqli_fetch_array($query_jumlah_harga);
 
echo $total = $data_jumlah_harga['subtotal'];

}
mysqli_close($db); 
        
?>