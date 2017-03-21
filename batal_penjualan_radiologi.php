<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $session_id = session_id();

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE session_id = '$session_id' ");

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>