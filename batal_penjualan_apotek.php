<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $session_id = session_id();

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
  
    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE session_id = '$session_id' AND (no_reg = '' OR no_reg IS NULL) ");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id' AND (no_reg = '' OR no_reg IS NULL) ");

    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    if ($query3 == TRUE)
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