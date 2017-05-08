<?php 
include 'db.php';
include_once 'sanitasi.php';
include 'persediaan.function.php';
$no = 1;
//Jika ingin menjalankan ini , di cek dahulu tanggalnya
$query_penjualan = $db->query("SELECT no_faktur,no_reg FROM penjualan WHERE tanggal = '2017-04-01' AND no_reg != '' ");
while($data_penjualan = mysqli_fetch_array($query_penjualan)){
	$no_faktur = $data_penjualan['no_faktur'];
	$no_reg = $data_penjualan['no_reg'];
	
	$query_history_tbs_penjualannya = $db->query("SELECT * FROM history_tbs_penjualan WHERE no_reg = '$no_reg'");
	while($data_tbs = mysqli_fetch_array($query_history_tbs_penjualannya)){

		$stok = cekStokHpp($data_tbs['kode_barang']);

		$hitung_stok = $stok - $data_tbs['jumlah_barang'];
		if($stok >= 0){

			$waktu = $data_tbs['tanggal']." ". $data_tbs['jam'];

			$query_insert_detail_penjualan = "INSERT INTO detail_penjualan 
			(no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,
			potongan,tax,hpp,tipe_produk,dosis,tanggal,jam,lab,ruangan,sisa,asal_satuan,
			waktu) VALUES ('$no_faktur','$no_reg','$data_tbs[kode_barang]',
			'$data_tbs[nama_barang]','$data_tbs[jumlah_barang]','$data_tbs[satuan]',
			'$data_tbs[harga]','$data_tbs[subtotal]','$data_tbs[potongan]','$data_tbs[tax]',
			'$data_tbs[hpp]','$data_tbs[tipe_barang]','$data_tbs[dosis]',
			'$data_tbs[tanggal]','$data_tbs[jam]','$data_tbs[lab]','$data_tbs[ruangan]',
			'$data_tbs[jumlah_barang]','$data_tbs[satuan]','$waktu')";

	 		if ($db->query($query_insert_detail_penjualan) === TRUE) {
				echo $no++. "-Data Berhasil Di Masukkan-". $no_faktur ."<br>";
	        } 
	        else {
	        	echo "Error: " . $query_insert_detail_penjualan . "<br>" . $db->error;
	        }

		}
		else{

		}

	}
}
	
?>