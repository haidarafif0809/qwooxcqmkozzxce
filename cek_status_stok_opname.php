<?php session_start();
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';

$session_id = session_id();
	

	$query_tbs_stok_opname = $db->query("SELECT kode_barang,nama_barang,selisih_fisik,fisik FROM tbs_stok_opname WHERE session_id = '$session_id' AND (no_faktur = '' OR no_faktur IS NULL)");


$arr = array();
$status_jual = 0;
while ($data_tbs_stok_opname = mysqli_fetch_array($query_tbs_stok_opname)) {
	
		$stok = cekStokHpp($data_tbs_stok_opname['kode_barang']);
		$selisih = $data_tbs_stok_opname['selisih_fisik'] ;
	
	if ($selisih < 0){
		$hasil_selisih = $selisih * -1;
		$selisih_stok = $stok - $hasil_selisih;


		if ($selisih_stok < 0) {
			# code...

			$temp = array(
			"kode_barang" => $data_tbs_stok_opname['kode_barang'],
			"nama_barang" => $data_tbs_stok_opname['nama_barang'],
			"stok" => $stok,
			"jumlah_jual" => $hasil_selisih
			);

			$status_jual += 1;

			array_push($arr, $temp);
		} 
		// end if selisih stok
	}

} //endwhile
// masukkan array yang berisi detail penjualan ke cache


	$data = json_encode($arr);

echo '{ "status": "'.$status_jual.'" ,"barang": '.$data.'}';


 ?>