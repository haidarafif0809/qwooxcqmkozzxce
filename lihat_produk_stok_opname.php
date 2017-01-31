<?php 

include 'db.php';
include 'sanitasi.php';

    $nama_produk = stringdoang($_GET['nama_produk']);
 
    //ambil data barang

$result = $db->query("SELECT * FROM barang WHERE nama_barang = '$nama_produk'");
$row = mysqli_fetch_array($result);

$select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
$ambil_sisa = mysqli_fetch_array($select);
$sisa_barang =$ambil_sisa['jumlah_barang'];
$row['kategori'] = $sisa_barang;
   
    echo json_encode($row);
    exit;
 


     ?>