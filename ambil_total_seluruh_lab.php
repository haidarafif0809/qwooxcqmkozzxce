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


$select = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total 
FROM detail_penjualan WHERE lab = 'Laboratorium' AND waktu >= '$dari_waktu' AND waktu <= '$sampai_waktu' ");
$row = mysqli_fetch_array($select);

 echo json_encode($row);
    exit;


 ?>