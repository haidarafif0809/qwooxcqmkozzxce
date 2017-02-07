<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST

$no_reg = $_POST['no_reg'];


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
 $data = mysqli_fetch_array($query);

 $query_op = $db->query("SELECT SUM(harga_jual) AS total_operasi FROM tbs_operasi WHERE  no_reg = '$no_reg' AND no_faktur IS NULL");
 $data_op = mysqli_fetch_array($query_op);

$total_penjualan = $data['total_penjualan'];
$total_operasi = $data_op['total_operasi'];

if ($data['total_penjualan'] == "") {
	$total_penjualan = 0;
}

if ($data_op['total_operasi'] == "") {
	$total_operasi = 0;
}

echo $total = $total_penjualan + $total_operasi;




        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        


  ?>


