<?php 
include 'sanitasi.php';
include 'db.php';
    

    $select = $db->query("SELECT * FROM penjualan WHERE tanggal = '2017-01-27'");
    while ($data = mysqli_fetch_array($select)) {

      $query = $db->query("UPDATE laporan_fee_produk SET jam = '$data[jam]', waktu = '$data[tanggal] $data[jam]' WHERE tanggal = '$data[tanggal]'");
        echo "UPDATE laporan_fee_produk SET jam = '$data[jam]', waktu = '$data[tanggal] $data[jam]' WHERE tanggal = '$data[tanggal]'";
     
    }
echo "Sukses";


    ?>