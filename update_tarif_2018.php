<?php

include 'db.php';
include_once 'sanitasi.php';

$barang = $db->query("SELECT barang_update.harga_jual as harga_jual_1,barang_update.harga_jual2 as harga_jual_2,barang_update.harga_jual4 as harga_jual_4,barang.nama_barang AS dari_barang ,barang_update.nama_barang dari_update FROM barang_update LEFT JOIN barang ON barang_update.nama_barang = barang.nama_barang HAVING dari_barang is not null");
while ($data = mysqli_fetch_array($barang)) {

    $update_produk = "UPDATE barang SET harga_jual = '$data[harga_jual_1]', harga_jual2 = '$data[harga_jual_2]',harga_jual4 = '$data[harga_jual_4]' WHERE nama_barang = '$data[nama_barang]' ";

    if ($db->query($update_produk) === true) {
        echo "SUKSES";
        echo "<br>";
    } else {
        echo "Error: " . $update_produk . "<br>" . $db->error;
    }
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
