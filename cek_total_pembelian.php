<?php session_start();


// memasukan file db.php
include 'db.php';
 // mengirim data no faktur menggunakan metode POST
$session_id = session_id();

 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query2 = $db->query("SELECT SUM(subtotal) AS total_pembelian FROM tbs_pembelian WHERE session_id = '$session_id'");
  $data_rows = mysqli_num_rows($query2);
 // menyimpan data sementara pada $query
   $query = $db->query("SELECT SUM(subtotal) AS total_pembelian FROM tbs_pembelian WHERE session_id = '$session_id'");
 $data = mysqli_fetch_array($query);

if($data_rows > 0)
{
	 echo $data['total_pembelian'];

}
else{
	echo 0.00;
}
// menampilkan file atau isi dari data total pembelian

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


