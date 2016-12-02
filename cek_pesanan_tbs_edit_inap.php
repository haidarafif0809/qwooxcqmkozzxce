<?php session_start();

// memasukan file db.php
include 'db.php';

// mengirim data no faktur menggunakan metode POST
$no_reg = $_POST['no_reg'];
$no_faktur = $_POST['no_faktur'];


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur' ");
 
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
