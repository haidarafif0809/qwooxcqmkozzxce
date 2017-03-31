<?php 
include 'db.php';
include 'sanitasi.php';

$kode = stringdoang($_POST['kode']);
$nama = stringdoang($_POST['nama']);

echo unlink($_POST["hapus"]);

$query =$db->query("UPDATE tbs_penjualan_radiologi SET foto = Null WHERE kode_barang = '$kode' AND nama_barang = '$nama'");
exit;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>