<?php 
    include 'db.php';
    include_once 'sanitasi.php';

$barang = $db->query("SELECT * FROM barangimport");
while ($data = mysqli_fetch_array($barang)) {

    $update_produk = "UPDATE barang SET harga_jual = '$data[harga_jual]', harga_jual2 = '$data[harga_jual2]' WHERE nama_barang = '$data[nama_barang]' ";


    if ($db->query($update_produk) === TRUE) {
        echo "SUKSES"; echo "<br>";
        }
    else{
        echo "Error: " . $update_produk . "<br>" . $db->error;
        }
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>