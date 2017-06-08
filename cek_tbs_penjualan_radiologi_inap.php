<?php session_start();

include 'db.php';
include 'sanitasi.php';


$no_reg = stringdoang($_POST['no_reg']);
$kode_barang = stringdoang($_POST['kode_barang']);
$no_pemeriksaan = stringdoang($_POST['no_pemeriksaan']);
$session_id = session_id();

$query = $db->query("SELECT no_reg FROM tbs_penjualan_radiologi WHERE kode_barang = '$kode_barang' AND no_reg = '$no_reg' AND radiologi = 'Radiologi' AND no_pemeriksaan = '$no_pemeriksaan'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

