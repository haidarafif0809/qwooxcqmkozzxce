<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_POST['kode_barang']);

	$jumlah_hppmasuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
    $ambil_jumlah_hppmasuk = mysqli_fetch_array($jumlah_hppmasuk);

    $jumlah_hppkeluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_barang FROM hpp_keluar WHERE kode_barang = '$kode_barang'");
    $ambil_jumlah_hppkeluar = mysqli_fetch_array($jumlah_hppkeluar);
     $ambil_jumlah_hppkeluar['jumlah_barang'];


echo $stok_barang = $ambil_jumlah_hppmasuk['jumlah_barang'] - $ambil_jumlah_hppkeluar['jumlah_barang'];
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>