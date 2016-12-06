<?php session_start();

// memsukan file db,php
include 'db.php';

$id = $_POST['id'];
$no_faktur = $_POST['no_faktur'];
$user =  $_SESSION['user_name'];

// INSERT HISTORY PENJUALAN
$penjualan = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur'");
$data_penjualan = mysqli_fetch_array($penjualan);

if ($data_penjualan['total'] == "") {
	$data_penjualan['total'] = 0;
}
if ($data_penjualan['potongan'] == "") {
	$data_penjualan['potongan'] = 0;
}
if ($data_penjualan['tax'] == "") {
	$data_penjualan['tax'] = 0;
}
if ($data_penjualan['sisa'] == "") {
	$data_penjualan['sisa'] = 0;
}
if ($data_penjualan['kredit'] == "") {
	$data_penjualan['kredit'] = 0;
}
if ($data_penjualan['nilai_kredit'] == "") {
	$data_penjualan['nilai_kredit'] = 0;
}
if ($data_penjualan['total_hpp'] == "") {
	$data_penjualan['total_hpp'] = 0;
}
if ($data_penjualan['tunai'] == "") {
	$data_penjualan['tunai'] = 0;
}
if ($data_penjualan['no_pesanan'] == "") {
	$data_penjualan['no_pesanan'] = 0;
}
if ($data_penjualan['biaya_admin'] == "") {
	$data_penjualan['biaya_admin'] = 0;
}
if ($data_penjualan['tanggal_jt'] == "") {
	$data_penjualan['tanggal_jt'] = '0000-00-00';
}
	


$insert_penjualan = "INSERT INTO history_penjualan (no_faktur, kode_gudang, kode_pelanggan, kode_meja, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, sisa, kredit, nilai_kredit, total_hpp, cara_bayar, tunai, ppn, no_pesanan, status_jual_awal, keterangan, biaya_admin,no_reg, nama, dokter, penjamin, no_resep, resep_dokter, apoteker, perawat, petugas_lain, jenis_penjualan,user_hapus) 
	VALUES ('$no_faktur', '$data_penjualan[kode_gudang]', '$data_penjualan[kode_pelanggan]',
	'$data_penjualan[kode_meja]','$data_penjualan[total]','$data_penjualan[tanggal]',
	'$data_penjualan[tanggal_jt]','$data_penjualan[jam]','$data_penjualan[user]',
	'$data_penjualan[sales]','$data_penjualan[status]','$data_penjualan[potongan]',
	'$data_penjualan[tax]','$data_penjualan[sisa]','$data_penjualan[kredit]',
	'$data_penjualan[nilai_kredit]','$data_penjualan[total_hpp]',
	'$data_penjualan[cara_bayar]','$data_penjualan[tunai]','$data_penjualan[ppn]',
	'$data_penjualan[no_pesanan]','$data_penjualan[status_jual_awal]',
	'$data_penjualan[keterangan]','$data_penjualan[biaya_admin]',
	'$data_penjualan[no_reg]','$data_penjualan[nama]','$data_penjualan[dokter]',
	'$data_penjualan[penjamin]','$data_penjualan[no_resep]','$data_penjualan[resep_dokter]',
	'$data_penjualan[apoteker]','$data_penjualan[perawat]','$data_penjualan[petugas_lain]',
	'$data_penjualan[jenis_penjualan]','$user')";
			
			if ($db->query($insert_penjualan) === TRUE) {
			} 
			
			else {
			echo "Error: " . $insert_penjualan . "<br>" . $db->error;
			}


// INSERT HISTORY DETAIL PENJUALAN
$detail_penjualan = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while($data_detail_penjualan = mysqli_fetch_array($detail_penjualan)){


if ($data_detail_penjualan['harga'] == "") {
	$data_detail_penjualan['harga'] = 0;
}
if ($data_detail_penjualan['subtotal'] == "") {
	$data_detail_penjualan['subtotal'] = 0;
}
if ($data_detail_penjualan['potongan'] == "") {
	$data_detail_penjualan['potongan'] = 0;
}
if ($data_detail_penjualan['tax'] == "") {
	$data_detail_penjualan['tax'] = 0;
}
if ($data_detail_penjualan['hpp'] == "") {
	$data_detail_penjualan['hpp'] = 0;
}
if ($data_detail_penjualan['sisa'] == "") {
	$data_detail_penjualan['sisa'] = 0;
}
if ($data_detail_penjualan['no_pesanan'] == "") {
	$data_detail_penjualan['no_pesanan'] = 0;
}
	$insert_detail_penjualan = "INSERT INTO history_detail_penjualan (no_faktur, kode_meja, tanggal, jam, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, status, hpp, sisa, no_pesanan, komentar,asal_satuan
		,no_reg,no_rm,tipe_produk,dosis,user_hapus) 
		VALUES ('$no_faktur', '$data_detail_penjualan[kode_meja]',
		'$data_detail_penjualan[tanggal]', '$data_detail_penjualan[jam]',
		'$data_detail_penjualan[kode_barang]', '$data_detail_penjualan[nama_barang]',
		'$data_detail_penjualan[jumlah_barang]', '$data_detail_penjualan[satuan]',
		'$data_detail_penjualan[harga]', '$data_detail_penjualan[subtotal]',
		'$data_detail_penjualan[potongan]', '$data_detail_penjualan[tax]',
		'$data_detail_penjualan[status]', '$data_detail_penjualan[hpp]',
		'$data_detail_penjualan[sisa]', '$data_detail_penjualan[no_pesanan]',
		'$data_detail_penjualan[komentar]', '$data_detail_penjualan[asal_satuan]',
		'$data_detail_penjualan[no_reg]','$data_detail_penjualan[no_rm]',
		'$data_detail_penjualan[tipe_produk]','$data_detail_penjualan[dosis]','$user')";

			if ($db->query($insert_detail_penjualan) === TRUE) {
			} 
			
			else {
			echo "Error: " . $insert_detail_penjualan . "<br>" . $db->error;
			}

}


$query3 = $db->query("DELETE FROM laporan_fee_produk WHERE no_faktur = '$no_faktur'");
$query4 = $db->query("DELETE FROM laporan_fee_faktur WHERE no_faktur = '$no_faktur'");
$query5 = $db->query("DELETE  FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");

if ($insert_penjualan == TRUE)
{

echo "sukses";

}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
