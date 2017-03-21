<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


// mengirim data no faktur menggunakan metode POST
$session_id = session_id();
$no_reg = stringdoang($_GET['no_reg']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_num_rows($query);

if ($data > 0) {
	echo "1";
}
else
{
	echo "0";
}
mysqli_close($db); 
        


  ?>


