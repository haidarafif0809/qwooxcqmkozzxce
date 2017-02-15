<?php session_start();

// memasukan file db.php
include 'db.php';

// mengirim data no faktur menggunakan metode POST
$session_id = session_id();


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND (no_reg IS NULL OR no_reg = '') AND lab IS NULL");
 
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


