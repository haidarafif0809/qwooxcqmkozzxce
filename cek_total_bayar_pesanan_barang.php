<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $no_faktur = $_POST['no_faktur'];
 $no_reg = $_POST['no_reg'];


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
 $data = mysqli_fetch_array($query);

 $sum_harga = $db->query("SELECT SUM(subtotal) AS harga_radiologi FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND status_periksa = '1' AND no_faktur = '$no_faktur'");
 $data_radiologi= mysqli_fetch_array($sum_harga);
 
 $subtotal = $data['total_penjualan'] + $data_radiologi['harga_radiologi'];
 $total_akhir =  intval($subtotal);

 echo $total_akhir;



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


