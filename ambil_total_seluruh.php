<?php 
include 'db.php';
include 'sanitasi.php';

$golongan = stringdoang($_GET['golongan']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);



$select = $db->query("SELECT SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total 
FROM detail_penjualan dp LEFT JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.berkaitan_dgn_stok = '$golongan' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ");
$row = mysqli_fetch_array($select);

 echo json_encode($row);
    exit;


 ?>