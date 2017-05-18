<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query_hapus_data_tbs = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE id = '$id'");

if ($query_hapus_data_tbs == TRUE){
echo "sukses";
}
else{
	
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
