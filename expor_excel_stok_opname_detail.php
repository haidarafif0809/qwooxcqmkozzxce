<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=detail_stok_opname.xls");
 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal= $_GET['sampai_tanggal'];



//menampilkan seluruh data yang ada pada tabel penjualan
$query_selisih_minus = $db->query("SELECT no_faktur ,kode_barang ,nama_barang ,stok_sekarang ,fisik ,selisih_fisik ,hpp ,selisih_harga FROM detail_stok_opname WHERE selisih_fisik < 0 AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");

$query_selisih_plus = $db->query("SELECT no_faktur ,kode_barang ,nama_barang ,stok_sekarang ,fisik ,selisih_fisik ,hpp ,selisih_harga FROM detail_stok_opname  WHERE selisih_fisik > 0 AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");
?>

<h3><b><center> Data Detail Stok Opname Dari Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?> </center><b></h3>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
			<th style='background-color: #4CAF50; color:white'> Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Hpp </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Harga </th>

			
			
		</thead>
		
		<tbody>
		<?php
		$total = 0;
		$total_selisih_minus = 0;

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query_selisih_minus))
			{
				
			
					# code...
					$total_selisih_minus = $total_selisih_minus + $data1['selisih_harga'];
				

				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['stok_sekarang'] ."</td>
			<td>". rp($data1['fisik']) ."</td>
			<td>". rp($data1['selisih_fisik']) ."</td>
			<td>". rp($data1['hpp']) ."</td>
			<td>". rp($data1['selisih_harga']) ."</td>

			</tr>";
			}

			echo "<tr>
			<td>Total Selisih Minus</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>". rp($total_selisih_minus) ."</td>
			
			</tr>";

			//Untuk Memutuskan Koneksi Ke Database


		?>
		</tbody>

	</table>



<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
			<th style='background-color: #4CAF50; color:white'> Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Hpp </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Harga </th>

			
			
		</thead>
		
		<tbody>
		<?php
	
		
		$total_selisih_plus = 0;
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query_selisih_plus))
			{
		

				if ($data1['selisih_harga'] > 0) {
					# code...
					$total_selisih_plus = $total_selisih_plus + $data1['selisih_harga'];
				}
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['stok_sekarang'] ."</td>
			<td>". rp($data1['fisik']) ."</td>
			<td>". rp($data1['selisih_fisik']) ."</td>
			<td>". rp($data1['hpp']) ."</td>
			<td>". rp($data1['selisih_harga']) ."</td>

			</tr>";
			}

			echo "<tr>
			<td>Total Selisih Plus</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>". rp($total_selisih_plus) ."</td>
			
			</tr>";

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>

	<p>Selisih Plus :<?php echo rp($total_selisih_plus); ?>
	<br>Selisih Minus : :<?php echo rp($total_selisih_minus); ?>  </p>
