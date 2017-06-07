<?php session_start();
include 'db.php';
include 'sanitasi.php';


header('Content-Type: application/json');

$no_reg = $_GET['no_reg'];

$query_tbs = $db->query("SELECT tp.id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,potongan,s.nama AS satuan FROM tbs_penjualan tp  INNER JOIN satuan s ON tp.satuan = s.id WHERE no_reg = '$no_reg' ");

$data_tbs_array = array();
while ($data_tbs = mysqli_fetch_array($query_tbs)) {

	array_push($data_tbs_array, ['id' => $data_tbs['id'],
								'no_reg' => $data_tbs['no_reg'],
								'kode_barang' => $data_tbs['kode_barang'],
								'nama_barang' => $data_tbs['nama_barang'],
								'jumlah_barang' => $data_tbs['jumlah_barang'],
								'harga' => $data_tbs['harga'],
								'subtotal' => $data_tbs['subtotal'],
								'satuan' => $data_tbs['satuan'],
								'potongan' => $data_tbs['potongan']]);

}



 echo json_encode(array('result'=>$data_tbs_array));

 ?>