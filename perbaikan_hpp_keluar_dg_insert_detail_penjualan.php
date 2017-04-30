<?php
include 'db.php';
include 'sanitasi.php';
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_detail_penjualan = $db->query("SELECT id,no_faktur,tanggal,jam,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,status,hpp,sisa,no_pesanan,asal_satuan,no_reg,no_rm,tipe_produk,dosis,lab,waktu,radiologi,ruangan FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while($data_detail_penjualan = mysqli_fetch_array($query_detail_penjualan)){
	$query_delete_detail_penjualan = "DELETE FROM detail_penjualan WHERE id = '$data_detail_penjualan[id]'";
	if ($db->query($query_delete_detail_penjualan) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_delete_detail_penjualan . "<br>" . $db->error;
	    }

	$query_insert_detail_penjualan = "INSERT INTO detail_penjualan(no_faktur,tanggal,jam,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,status,hpp,sisa,no_pesanan,asal_satuan,no_reg,no_rm,tipe_produk,dosis,lab,waktu,radiologi,ruangan) VALUES ('$data_detail_penjualan[no_faktur]','$data_detail_penjualan[tanggal]','$data_detail_penjualan[jam]','$data_detail_penjualan[kode_barang]','$data_detail_penjualan[nama_barang]','$data_detail_penjualan[jumlah_barang]','$data_detail_penjualan[satuan]','$data_detail_penjualan[harga]','$data_detail_penjualan[subtotal]','$data_detail_penjualan[potongan]','$data_detail_penjualan[tax]','$data_detail_penjualan[status]','$data_detail_penjualan[hpp]','$data_detail_penjualan[sisa]','$data_detail_penjualan[no_pesanan]','$data_detail_penjualan[asal_satuan]','$data_detail_penjualan[no_reg]','$data_detail_penjualan[no_rm]','$data_detail_penjualan[tipe_produk]','$data_detail_penjualan[dosis]','$data_detail_penjualan[lab]','$data_detail_penjualan[waktu]','$data_detail_penjualan[radiologi]','$data_detail_penjualan[ruangan]')";

		if ($db->query($query_insert_detail_penjualan) === TRUE) {
	    } 
	    else {
	    echo "Error: " . $query_insert_detail_penjualan . "<br>" . $db->error;
	    }

}// end while $data_detail_penjualan

 ?>
