<?php 
include 'db.php';

$select = $db->query("SELECT * FROM hpp_keluar WHERE no_faktur_hpp_masuk = '4/SO/01/17' AND kode_barang != 'B152' AND tanggal >= '2017-02-01' AND tanggal <= '2017-02-09' ");
while($amb = mysqli_fetch_array($select))
{


$select33 = $db->query("SELECT no_faktur_hpp_masuk,no_faktur,kode_barang FROM hpp_keluar_buatan WHERE no_faktur = '$amb[no_faktur]' AND kode_barang = '$amb[kode_barang]' ");
$kel = mysqli_fetch_array($select33);

$update = $db->query("UPDATE hpp_keluar SET no_faktur_hpp_masuk = '$kel[no_faktur_hpp_masuk]' WHERE no_faktur = '$kel[no_faktur]' AND kode_barang = '$kel[kode_barang]'  AND tanggal >= '2017-02-01' AND tanggal <= '2017-02-09'  ");



}


echo "selesai";
 ?>