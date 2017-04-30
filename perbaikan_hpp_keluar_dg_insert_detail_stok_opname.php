<?php
include 'db.php';
include 'sanitasi.php';
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_detail_stok_opname = $db->query("SELECT id,no_faktur,tanggal,jam,kode_barang,nama_barang,awal,masuk,keluar,stok_sekarang,fisik,selisih_fisik,selisih_harga,harga,hpp FROM detail_stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while($data_detail_stok_opname = mysqli_fetch_array($query_detail_stok_opname)){
	

	$query_delete_detail_stok_opname = "DELETE FROM detail_stok_opname WHERE id = '$data_detail_stok_opname[id]'";
	if ($db->query($query_delete_detail_stok_opname) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_delete_detail_stok_opname . "<br>" . $db->error;
	    }

	$query_insert_detail_stok_opname = "INSERT INTO detail_stok_opname(no_faktur,tanggal,jam,kode_barang,nama_barang,awal,masuk,keluar,stok_sekarang,fisik,selisih_fisik,selisih_harga,harga,hpp) VALUES ('$data_detail_stok_opname[no_faktur]','$data_detail_stok_opname[tanggal]','$data_detail_stok_opname[jam]','$data_detail_stok_opname[kode_barang]','$data_detail_stok_opname[nama_barang]','$data_detail_stok_opname[awal]','$data_detail_stok_opname[masuk]','$data_detail_stok_opname[keluar]','$data_detail_stok_opname[stok_sekarang]','$data_detail_stok_opname[fisik]','$data_detail_stok_opname[selisih_fisik]','$data_detail_stok_opname[selisih_harga]','$data_detail_stok_opname[harga]','$data_detail_stok_opname[hpp]')";

		if ($db->query($query_insert_detail_stok_opname) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_insert_detail_stok_opname . "<br>" . $db->error;
	    }

}// end while $data_detail_stok_opname

 ?>