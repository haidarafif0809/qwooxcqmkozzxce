<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=detail_item_keluar.xls");
 

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal= $_GET['sampai_tanggal'];



//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT *, s.nama FROM detail_item_keluar dik INNER JOIN satuan s ON dik.satuan = s.id WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");

?>
<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<h3><b><center> Data Detail Item Keluar Dari Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?> </center> </b></h3>
<br>
<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Gudang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Harga </th>
			<th style='background-color: #4CAF50; color:white'> Subotal </th>
		
		</thead>
		
		<tbody>
		<?php
		$total = 0;
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				$total = $total + $data1['subtotal'];

			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['gudang_item_keluar'] ."</td>
			<td>". $data1['jumlah'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>
			
			</tr>";
			 } 


			echo "<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>". rp($total) ."</td>
			
			</tr>";
			
			
			//Untuk Memutuskan Koneksi Ke Database
		mysqli_close($db);
		?>
		</tbody>

	</table>