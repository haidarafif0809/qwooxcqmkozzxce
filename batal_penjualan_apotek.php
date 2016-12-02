<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $session_id = session_id();

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_penjualan WHERE session_id = '$session_id'");
    $query = $db->query("DELETE FROM tbs_fee_produk WHERE session_id = '$session_id'");

    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=form_penjualan_kasir_apotek.php">';
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>