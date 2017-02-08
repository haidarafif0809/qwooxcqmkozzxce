<table border="1">
<tr>
<td>Tanggal</td>
<td>No Faktur</td>
<td>Tax</td> 
<td>Potongan</td> 
<td>Total Penjualan</td> 
<td>Total Penjualan (asal)</td>
<td>Total Detail Penjualan</td> 
<td>Selisih</td> 
</tr>
<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$tanggal = date('Y-m-d');
$query = $db->query("SELECT no_faktur,total,tanggal,jam,potongan,tax FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'	");


while ($data = $query->fetch_array()) {
	# code...
$total_asli = ($data['total'] + $data['potongan']) - $data['tax'];

	$query_detail = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE  no_faktur = '$data[no_faktur]' GROUP BY no_faktur");

	$v_detail = $query_detail->fetch_array();
$selisih = $total_asli - $v_detail['subtotal'];
if($selisih != 0){
	echo "<tr><td>".$data['tanggal']."</td><td>".$data['no_faktur']."</td><td>".$data['tax']."</td><td>".$data['potongan']."</td><td>".$data['total']."</td><td>".$total_asli."</td><td>".$v_detail['subtotal']."</td><td>".$selisih."</td></tr>";
}



}

 ?>

 </table>