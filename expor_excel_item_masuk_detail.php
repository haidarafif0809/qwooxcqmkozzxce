<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=rekab_detail_item_masuk.xls");
 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];

		$detail = $db->query("SELECT dim.id,dim.no_faktur,dim.tanggal,dim.kode_barang,dim.nama_barang,dim.jumlah,dim.harga,dim.subtotal,s.nama FROM detail_item_masuk dim INNER JOIN  satuan s ON dim.satuan = s.id WHERE  dim.tanggal >= '$dari_tanggal' AND dim.tanggal <= '$sampai_tanggal'");
?>
<h3><b><center> Data Detail Item Masuk Dari <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?></center></b></h3>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style> 
<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal</th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Harga </th>
			<th style='background-color: #4CAF50; color:white'> Subtotal </th>

			
		</thead>
		
		<tbody>
		<?php  
			$total = 0;
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($detail))
			{
				$total = $total + $data1['subtotal'];
				//menampilkan data
			echo"<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>

			</tr>";
			}
			echo"<tr>
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


