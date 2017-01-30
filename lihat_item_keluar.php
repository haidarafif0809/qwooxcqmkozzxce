<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_GET['kode_barang']);
 
    //ambil data barang

$result = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
$row = mysqli_fetch_array($result);

$cek_harga_hpp = $db->query("SELECT total_nilai,jumlah_kuantitas FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND sisa != 0 ORDER BY waktu DESC LIMIT 1  ");
$harga_kel = mysqli_fetch_array($cek_harga_hpp);

        $jumlah_kuantitas = $harga_kel['jumlah_kuantitas'];

        if ($jumlah_kuantitas == 0)
        {
            $jumlah_kuantitas = 1;
        }

	$harga_hpp = $harga_kel['total_nilai'] / $jumlah_kuantitas;

    $row['harga_jual'] = $harga_hpp;

    echo json_encode($row);
    exit;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>