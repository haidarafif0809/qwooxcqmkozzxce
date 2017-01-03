<?php 
    include 'db.php';
    include_once 'sanitasi.php';

$select_detail_penjualan = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '2/JL/07/16'");
while ($dp = mysqli_fetch_array($select_detail_penjualan)) {

    $delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE id = '$dp[id]' ");
    
    $insert_detail_penjualan = "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa, kode_meja) VALUES ('$dp[no_faktur]', '$dp[tanggal]', '$dp[jam]', '$dp[kode_barang]','$dp[nama_barang]','$dp[jumlah_barang]','$dp[asal_satuan]','$dp[satuan]','$dp[harga]','$dp[subtotal]','$dp[potongan]','$dp[tax]', '$dp[sisa]', '1')";

    echo "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa, kode_meja) VALUES ('$dp[no_faktur]', '$dp[tanggal]', '$dp[jam]', '$dp[kode_barang]','$dp[nama_barang]','$dp[jumlah_barang]','$dp[asal_satuan]','$dp[satuan]','$dp[harga]','$dp[subtotal]','$dp[potongan]','$dp[tax]', '$dp[sisa]', '1')";

    if ($db->query($insert_detail_penjualan) === TRUE) {
        echo "SUKSES";
        } 
    else{
        echo "Error: " . $insert_detail_penjualan . "<br>" . $db->error;
        }
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>