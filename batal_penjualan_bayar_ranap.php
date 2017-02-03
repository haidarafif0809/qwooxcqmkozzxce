<?php session_start();
    // memasukan file db.php
    include 'db.php';
     include 'sanitasi.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $no_reg = stringdoang($_GET['no_reg']);
    $no_faktur = stringdoang($_GET['no_faktur']);
    $no_rm = stringdoang($_GET['no_rm']);
    $kode_gudang = stringdoang($_GET['kode_gudang']);
    $nama_gudang = stringdoang($_GET['nama_gudang']);
    $nama_pelanggan = stringdoang($_GET['nama_pelanggan']);

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
    $query = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");

    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=bayar_pesanan_barang_ranap.php?no_reg='.$no_reg.'&no_faktur='.$no_faktur.'&kode_pelanggan='.$no_rm.'&kode_pelanggan='.$no_rm.'&nama_gudang='.$nama_gudang.'&nama_pelanggan='.$nama_pelanggan.'&kode_gudang='.$kode_gudang.'">';
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>