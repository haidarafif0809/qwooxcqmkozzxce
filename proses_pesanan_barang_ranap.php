<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$no_reg = stringdoang($_GET['no_reg']);
$kode_pelanggan = stringdoang($_GET['kode_pelanggan']);
$kode_gudang = stringdoang($_GET['kode_gudang']);
$nama_pelanggan = stringdoang($_GET['nama_pelanggan']);
$jam_sekarang = date('H:i:sa');

$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg'");
}	


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_reg = '$no_reg'");
while ($data = mysqli_fetch_array($perintah)){

$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_reg, no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp,tanggal,jam,tipe_barang,lab) VALUES ('$data[no_reg]', '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[hpp]','$data[tanggal]','$data[jam]','$data[tipe_produk]','$data[lab]')");


}



$fee_produk = $db->query("SELECT * FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");
$x = mysqli_num_rows($fee_produk);

if ($x > 0){

$perintah7 = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg'");
}

$fee = $db->query("SELECT * FROM laporan_fee_produk WHERE no_reg = '$no_reg' ");
while ($data_fee = mysqli_fetch_array($fee)){

$barang = $db->query("SELECT * FROM barang WHERE kode_barang = '$data_fee[kode_produk]' ");
$y = mysqli_num_rows($barang);

if ($y > 0) {
	$insert2 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_fee[no_faktur]','$data_fee[no_reg]','$data_fee[no_rm]','$data_fee[nama_petugas]','$data_fee[kode_produk]','$data_fee[nama_produk]','$data_fee[jumlah_fee]','$data_fee[tanggal]','$data_fee[jam]')";

      if ($db->query($insert2) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $insert2 . "<br>" . $db->error;
      }
}



}


 header ('location:bayar_pesanan_barang_ranap.php?no_faktur='.$no_faktur.'&no_reg='.$no_reg.'&kode_pelanggan='.$kode_pelanggan.'&nama_pelanggan='.$nama_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>


