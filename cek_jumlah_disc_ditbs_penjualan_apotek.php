<?php session_start();

include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);

$query_tbs_penjualan = $db->query("SELECT sum(potongan) as potongannya FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);
$jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);
if ($jumlah_data_tbs_penjualan < 0) {
	# code...
	$jumlahnya = 0;
}
else{

	$jumlahnya = 1;
}
$datanya = array(
    'potongannya' => $data_tbs_penjualan['potongannya'],
    'jumlahnya' => $jumlahnya    
   );
echo json_encode($datanya);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


