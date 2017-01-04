<?php 
    // memasukan file db.php
    include 'sanitasi.php';    // memasukan file db.php
    include 'db.php';
    // mengirim data no faktur menggunakan metode POST
    $nama = stringdoang($_POST['dari_akun']);
    // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
    // berdasarkan no faktur
// MENCARI JUMLAH KAS
            $query0 = $db->query("SELECT SUM(debit) - SUM(kredit) AS total_kas FROM jurnal_trans WHERE kode_akun_jurnal = '$nama'");
            $cek0 = mysqli_fetch_array($query0);
           echo $total_kas = $cek0['total_kas'];

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>