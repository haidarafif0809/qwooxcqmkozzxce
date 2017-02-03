<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan_penjualan_golongan.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_jam = stringdoang($_GET['dari_jam']);
$sampai_jam = stringdoang($_GET['sampai_jam']);
$golongan = stringdoang($_GET['golongan']);

$dari_waktu = $dari_tanggal." ".$dari_jam;
$sampai_waktu = $sampai_tanggal." ".$sampai_jam;

$jumlah_jual_awal = 0;
$jumlah_beli_awal = 0;



//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT dp.nama_barang, SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total
FROM detail_penjualan dp INNER JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.golongan_barang = '$golongan' AND dp.waktu >= '$dari_waktu' AND dp.waktu <= '$sampai_waktu' GROUP BY dp.kode_barang ORDER BY dp.id ASC ");

?>
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>
 <h3><center>Data Penjualan / Golngan Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>

<center>
 <table id="tableuser" class="table">
					<thead>
					<th style='background-color: #4CAF50; color:white'> Nama Produk </th>
					<th style='background-color: #4CAF50; color:white'> Jumlah Produk  </th>
					<th style='background-color: #4CAF50; color:white'> Total Nilai </th>
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($perintah))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['nama_barang'] ."</td>
					<td>". $data1['jumlah'] ."</td>
					<td>". $data1['total'] ."</td>";

					echo"</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
</table>
</center>
