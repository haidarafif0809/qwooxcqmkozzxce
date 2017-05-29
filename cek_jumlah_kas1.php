<?php 
    // memasukan file db.php
    include 'db.php';
    include 'sanitasi.php';

    // mengirim data no faktur menggunakan metode POST
     $nama = $_POST['cara_bayar'];
            
            $query0 = $db->query("SELECT SUM(debit) - SUM(kredit) AS total_kas FROM jurnal_trans WHERE kode_akun_jurnal = '$nama'");
            $cek0 = mysqli_fetch_array($query0);
           echo $total_kas = koma($cek0['total_kas'],2);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>