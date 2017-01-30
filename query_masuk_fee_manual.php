<?php 
include 'db.php';
include 'sanitasi.php';

$select = $db->query("SELECT * FROM penjualan WHERE dokter = '296' ");
while($my = mysqli_fetch_array($select)){

$select4 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$my[no_faktur]'");
while($my2 = mysqli_fetch_array($select4)){

$waktu = $my2['tanggal']." ".$my2['jam'];

// PERHITUNGAN UNTUK FEE DOKTER
$ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '296' AND kode_produk = '$my2[kode_barang]'");
$cek_fee_dokter1 = mysqli_num_rows($ceking);
$dataui = mysqli_fetch_array($ceking);

if ($cek_fee_dokter1 > 0){
if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

{ 

$hasil_hitung_fee_persen = $my2['subtotal'] * $dataui['jumlah_prosentase'] / 100;

$query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg,waktu) VALUES ('296', '$my2[no_faktur]', '$my2[kode_barang]', '$my2[nama_barang]', '$hasil_hitung_fee_persen', '$my2[tanggal]', '$my2[jam]', '$my2[no_rm]', '$my2[no_reg]','$waktu')");

}



else
{

$hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $my2['jumlah'];

$query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg,waktu) VALUES ('296', '$my2[no_faktur]', '$my2[kode_barang]', '$my2[nama_barang]', '$hasil_hitung_fee_nominal', '$my2[tanggal]', '$my2[jam]', '$my2[no_rm]', '$my2[no_reg]',$waktu')");

  }


}



}


}
 ?>