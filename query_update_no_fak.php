<?php  
include 'db.php'; 
 
$no_faktur_terakhir_bener = 1004; 
 
 
$gantis = $db->query("SELECT * FROM penjualan WHERE id >= '5680' AND id <= '5704' "); 
while($ganti = mysqli_fetch_array($gantis)) 
{ 
  
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener + 1; 
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener."/JL/03/17"; 
 
 
$update = $db->query("UPDATE penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE  tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  "); 
 

$update_detail = $db->query("UPDATE detail_penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE  tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'   "); 

$update_fee = $db->query("UPDATE laporan_fee_produk SET no_faktur = '$no_faktur_terakhir_bener' WHERE  tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'   "); 
 
  
 $hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur = '$no_faktur_terakhir_bener' WHERE  tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]' "); 
  
 $hpp_keluar = $db->query("UPDATE jurnal_trans SET no_faktur = '$no_faktur_terakhir_bener' WHERE  DATE(waktu_jurnal) = '$ganti[tanggal]' AND TIME(waktu_jurnal) = '$ganti[jam]' "); 
 
}  
 
 
 echo "sukses";
 ?>