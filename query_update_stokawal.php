<?php 
    include 'db.php';
    include_once 'sanitasi.php';

$select_detail_penjualan = $db->query("SELECT * FROM cadangan  ");
while ($dp = mysqli_fetch_array($select_detail_penjualan)) {

$select = $db->query("SELECT kode_barang FROM barang WHERE nama_barang = '$dp[nama_barang]'");
$ambil = mysqli_fetch_array($select);

    
    $insert_detail_penjualan = "UPDATE cadangan SET kode_barang = '$ambil[kode_barang]' WHERE nama_barang = '$dp[nama_barang]' ";


    if ($db->query($insert_detail_penjualan) === TRUE) {
        echo "SUKSES";
        } 
    else{
        echo "Error: " . $insert_detail_penjualan . "<br>" . $db->error;
        }
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>