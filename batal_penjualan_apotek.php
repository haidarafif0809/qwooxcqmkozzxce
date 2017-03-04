<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $session_id = session_id();

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
  
    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE session_id = '$session_id' AND (no_reg = '' OR no_reg IS NULL) ");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id' AND (no_reg = '' OR no_reg IS NULL) ");

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>