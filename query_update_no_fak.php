<?php 
include 'db.php';

$no_faktur_terakhir_bener = 4345;


$gantis = $db->query("SELECT * FROM penjualan WHERE tanggal = '2017-01-27' ");
while($ganti = mysqli_fetch_array($gantis))
{
 
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener + 1;
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener."/JL/01/17";


$update = $db->query("UPDATE penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  ");

$update_detail = $db->query("UPDATE detail_penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  ");

$update_fee = $db->query("UPDATE laporan_fee_produk SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  ");

$waktu = $ganti['tanggal']." ".$ganti['jam'];



$hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' 
	AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]' ");



echo "UPDATE hpp_keluar SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' 
	AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'";
	echo "<br>";


	echo "UPDATE laporan_fee_produk SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'";
	echo "<br>"; 

echo "UPDATE detail_penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'";
echo "<br>"; 


echo "UPDATE penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'";
echo "<br>";

} 



 ?>