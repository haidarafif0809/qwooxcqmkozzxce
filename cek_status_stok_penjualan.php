<?php 
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';
include 'cache.class.php';

  $c = new Cache();
  $c->setCache('detail_penjualan');


$no_reg = stringdoang($_GET['no_reg']);
	
		$query_tbs_penjualan = $db->query("SELECT tp.id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,potongan,s.nama AS satuan,tax,tipe_barang FROM tbs_penjualan tp  INNER JOIN satuan s ON tp.satuan = s.id WHERE no_reg = '$no_reg' ");


 $data_detail = array();
$arr = array();
$status_jual = 0;


while ($data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan)) {
	

	if ($data_tbs_penjualan['tipe_barang'] == 'Barang') {
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
		// end if selisih stok
	} 
	// end if tipe barang

// memasukkan data ke array detail penjualan yang akan di masukkan ke cache
array_push($data_detail, ['kode_barang' => $data_tbs_penjualan['kode_barang'],
              'nama_barang' => $data_tbs_penjualan['nama_barang'],
              'satuan'  => $data_tbs_penjualan['satuan'],
			'jumlah_barang' => $data_tbs_penjualan['jumlah_barang'],
			'harga'=> $data_tbs_penjualan['harga'],
			'subtotal'=> $data_tbs_penjualan['subtotal'],
			'potongan'=> $data_tbs_penjualan['potongan'],
			'pajak' => $data_tbs_penjualan['tax']]);

	} //endwhile
// masukkan array yang berisi detail penjualan ke cache

   $c->store($no_reg, $data_detail);

	$data = json_encode($arr);

	$data_detail =  json_encode($data_detail);

echo '{ "status": "'.$status_jual.'" ,"barang": '.$data.',"data_detail":'.$data_detail.'}';


 ?>