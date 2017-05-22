<?php session_start();

include 'db.php';

$no_faktur = $_GET(['no_faktur']);
 
$query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_faktur = '$no_faktur'");

$query_hapus_tbs_fee = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur'");

if ($query == TRUE){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=lap_penjualan.php">';
}
else{
    echo "failed";
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>