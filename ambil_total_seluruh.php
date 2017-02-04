<?php 
include 'db.php';
include 'sanitasi.php';

$dari_jam = stringdoang($_GET['dari_jam']);
$golongan = stringdoang($_GET['golongan']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_jam = stringdoang($_GET['sampai_jam']);

$dari_waktu = $dari_tanggal." ".$dari_jam;
$sampai_waktu = $sampai_tanggal." ".$sampai_jam;




$select = $db->query("SELECT SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total 
FROM detail_penjualan dp LEFT JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.golongan_barang = '$golongan' AND dp.waktu >= '$dari_waktu' AND dp.waktu <= '$sampai_waktu'");
$row = mysqli_fetch_array($select);

 echo json_encode($row);
    exit;


 ?>