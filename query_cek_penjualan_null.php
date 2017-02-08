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
$query = $db->query("SELECT penjualan.no_faktur,penjualan.total,penjualan.tanggal,penjualan.jam,penjualan.potongan,penjualan.tax,SUM(detail_penjualan.subtotal) AS total_detail,(penjualan.total - penjualan.tax + penjualan.potongan) - SUM(detail_penjualan.subtotal) AS selisih,(penjualan.total - penjualan.tax + penjualan.potongan) AS total_asli FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' LEFT JOIN detail_penjualan ON detail_penjualan.no_faktur = penjualan.no_faktur GROUP BY detail_penjualan.no_faktur HAVING selisih != 0  	");


while ($data = $query->fetch_array()) {
	# code...

	echo "<tr><td>".$data['tanggal']."</td><td>".$data['no_faktur']."</td><td>".$data['tax']."</td><td>".$data['potongan']."</td><td>".$data['total']."</td><td>".$data['selisih']."</td><td>".$data['total_detail']."</td><td>".$data['selisih']."</td></tr>";




}

 ?>

 </table>