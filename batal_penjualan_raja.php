<?php session_start();
    // memasukan file db.php
    include 'db.php';
     include 'sanitasi.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $session_id = session_id();
    $no_reg = stringdoang($_GET['no_reg']);

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg'");
    $query2 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg'");

    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=form_penjualan_kasir.php?no_reg='.$no_reg.'">';
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>