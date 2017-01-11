<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$no_reg = stringdoang($_GET['no_reg']);
$no_rm = stringdoang($_GET['no_rm']);
$nama_pasien = stringdoang($_GET['nama_pasien']);
$kode_gudang = stringdoang($_GET['kode_gudang']);
$nama_gudang = stringdoang($_GET['nama_gudang']);

$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
while ($data = mysqli_fetch_array($perintah)){


if ($data['harga'] == "") {
      $data['harga'] = 0;
}
if ($data['subtotal'] == "") {
      $data['subtotal'] = 0;
}
if ($data['potongan'] == "") {
      $data['potongan'] = 0;
}
if ($data['hpp'] == "") {
      $data['hpp'] = 0;
}

 $query6 = "INSERT INTO tbs_penjualan (no_faktur,no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,hpp,lab) VALUES ('$no_faktur','$no_reg','$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[satuan]','$data[harga]','$data[subtotal]','$data[tipe_produk]','$data[tanggal]','$data[jam]','$data[potongan]','$data[tax]','$data[hpp]','$data[lab]')";





      if ($db->query($query6) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $query6 . "<br>" . $db->error;
      }


}

$perintah30 = $db->query("SELECT * FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
$data1 = mysqli_num_rows($perintah30);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
}


$fee_produk = $db->query("SELECT * FROM laporan_fee_produk WHERE no_reg = '$no_reg' ");


while ($data_fee = mysqli_fetch_array($fee_produk)){

$insert2 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_fee[no_faktur]','$data_fee[no_reg]','$data_fee[no_rm]','$data_fee[nama_petugas]','$data_fee[kode_produk]','$data_fee[nama_produk]','$data_fee[jumlah_fee]','$data_fee[tanggal]','$data_fee[jam]')";

echo "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_fee[no_faktur]','$data_fee[no_reg]','$data_fee[no_rm]','$data_fee[nama_petugas]','$data_fee[kode_produk]','$data_fee[nama_produk]','$data_fee[jumlah_fee]','$data_fee[tanggal]','$data_fee[jam]')";


      if ($db->query($insert2) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $insert2 . "<br>" . $db->error;
      }


}

       header ('location:bayar_pesanan_barang_raja.php?no_faktur='.$no_faktur.'&no_rm='.$no_rm.'&kode_gudang='.$kode_gudang.'&nama_pasien='.$nama_pasien.'&no_reg='.$no_reg.'&nama_gudang='.$nama_gudang.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>


