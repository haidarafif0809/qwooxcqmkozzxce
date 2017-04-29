<?php
include 'db.php';
include 'sanitasi.php';
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_detail_item_keluar = $db->query("SELECT id,no_faktur,tanggal,jam,kode_barang,nama_barang,gudang_item_keluar,jumlah,satuan,harga,subtotal FROM detail_item_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while($data_detail_item_keluar = mysqli_fetch_array($query_detail_item_keluar)){
	$query_delete_detail_item_keluar = "DELETE FROM detail_item_keluar WHERE id = '$data_detail_item_keluar[id]'";
	if ($db->query($query_delete_detail_item_keluar) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_delete_detail_item_keluar . "<br>" . $db->error;
	    }

	$query_insert_detail_item_keluar = "INSERT INTO detail_item_keluar(no_faktur,tanggal,jam,kode_barang,nama_barang,gudang_item_keluar,jumlah,satuan,harga,subtotal) VALUES ('$data_detail_item_keluar[no_faktur]','$data_detail_item_keluar[tanggal]','$data_detail_item_keluar[jam]','$data_detail_item_keluar[kode_barang]','$data_detail_item_keluar[nama_barang]','$data_detail_item_keluar[gudang_item_keluar]','$data_detail_item_keluar[jumlah]','$data_detail_item_keluar[satuan]','$data_detail_item_keluar[harga]','$data_detail_item_keluar[subtotal]')";

		if ($db->query($query_insert_detail_item_keluar) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_insert_detail_item_keluar . "<br>" . $db->error;
	    }

}// end while $data_detail_item_keluar

 ?>