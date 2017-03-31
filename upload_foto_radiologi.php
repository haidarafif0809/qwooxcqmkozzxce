<?php
include 'sanitasi.php';
include 'db.php';


$no_reg = stringdoang($_POST['no_reg']);
$kode_barang = stringdoang($_POST['kode']);
$data_foto = stringdoang($_POST['data_foto']);


$query = $db->prepare("UPDATE tbs_penjualan_radiologi SET foto = ? WHERE no_reg = ? AND kode_barang = ? ");

$query->bind_param("sss",
  $data_foto, $no_reg, $kode_barang);

$query->execute();



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>