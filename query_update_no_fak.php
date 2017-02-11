<?php 
include 'db.php';

$no_faktur_terakhir_bener = 1803;


$gantis = $db->query("SELECT * FROM penjualan WHERE id >= '9049' AND id <= '9091' ");
while($ganti = mysqli_fetch_array($gantis))
{
 
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener + 1;
$no_faktur_terakhir_bener = $no_faktur_terakhir_bener."/JL/02/17";



$update_detail = $db->query("UPDATE detail_penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  ");

$update_fee = $db->query("UPDATE laporan_fee_produk SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]'  ");

$hpp_keluar = $db->query("UPDATE hpp_keluar SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]' ");

$update = $db->query("UPDATE penjualan SET no_faktur = '$no_faktur_terakhir_bener' WHERE no_faktur = '$ganti[no_faktur]' AND tanggal = '$ganti[tanggal]' AND jam = '$ganti[jam]' ");

} 

echo "SUKES";

?>