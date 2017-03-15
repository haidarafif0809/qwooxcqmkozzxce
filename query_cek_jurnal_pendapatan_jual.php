<table border="1">
	<thead>
		<th>No Faktur</th>
		<th>Tanggal</th>
		<th>Pendapatan Jual Seharusnya </th>
		<th>Pendapatan Jual di jurnal</th>
		<th>Selisih Pendapatan Jual </th>
	</thead>
<tbody>

<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_penjualan = $db->query("SELECT p.no_faktur,p.total,p.potongan ,p.tanggal FROM penjualan p  WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");


while ($data_penjualan = mysqli_fetch_array($query_penjualan)) {

$query_jurnal = $db->query("SELECT kredit FROM jurnal_trans WHERE no_faktur = '$data_penjualan[no_faktur]' AND kode_akun_jurnal = '4-1100'");
$data_jurnal = mysqli_fetch_array($query_jurnal);
$pendapatan_jual = $data_penjualan['total'] + $data_penjualan['potongan'];

$selisih_pendapatan_jual = $pendapatan_jual - $data_jurnal['kredit'];

//jika ada selisih maka pendapatan jualnya langsung di update ke yang seharusnya 
if ($selisih_pendapatan_jual != 0) {
	# code...

	$update_jurnal_pendapatan_jual = $db->query("UPDATE jurnal_trans SET kredit = '$pendapatan_jual' WHERE no_faktur = '$data_penjualan[no_faktur]' AND kode_akun_jurnal = '4-1100' ");

}

	echo "  <tr>
			<td>".$data_penjualan['no_faktur']."</td>
			<td>".$data_penjualan['tanggal']."</td>
			<td>".$pendapatan_jual."</td>
			<td>".$data_jurnal['kredit']."</td>
			<td>".$selisih_pendapatan_jual."</td>

			</tr>";

}


 ?>

</tbody>
</table>