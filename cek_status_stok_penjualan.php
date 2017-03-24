<?php 
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';


$no_reg = stringdoang($_GET['no_reg']);
	
		$query_tbs_penjualan = $db->query("SELECT kode_barang,
	nama_barang,
	jumlah_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Barang'");



$arr = array();
$status_jual = 0;
while ($data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan)) {
	# code...


	$stok = cekStokHpp($data_tbs_penjualan['kode_barang']);


	$selisih_stok = $stok - $data_tbs_penjualan['jumlah_barang'];


	if ($selisih_stok < 0) {
		# code...

		$temp = array(
		"kode_barang" => $data_tbs_penjualan['kode_barang'],
		"nama_barang" => $data_tbs_penjualan['nama_barang'],
		"stok" => $stok,
		"jumlah_jual" => $data_tbs_penjualan['jumlah_barang']
		);

	$status_jual += 1;

		array_push($arr, $temp);
	}



	} //endwhile

	$data = json_encode($arr);

echo '{ "status": "'.$status_jual.'" ,"barang": '.$data.'}';


 ?>