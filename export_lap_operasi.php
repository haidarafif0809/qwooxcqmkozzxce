<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_laporan_operasi.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT p.no_faktur,kk.nama AS kelas_kamar,c.nama AS nama_cito,u.nama AS petugas_input,o.nama_operasi,ho.no_reg,ho.harga_jual,ho.waktu,ho.id,ho.sub_operasi,ho.operasi FROM hasil_operasi ho INNER JOIN operasi o ON ho.operasi = o.id_operasi INNER JOIN user u ON ho.petugas_input = u.id INNER JOIN sub_operasi so ON ho.sub_operasi = so.id_sub_operasi INNER JOIN cito c ON so.id_cito = c.id INNER JOIN kelas_kamar kk ON so.id_kelas_kamar = kk.id INNER JOIN penjualan p ON ho.no_reg = p.no_reg WHERE DATE(ho.waktu) >= '$dari_tanggal' AND DATE(ho.waktu) <= '$sampai_tanggal' ");

?>
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>
 <h3><center>Data Seluruh Operasi Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>

 <table id="tableuser" class="table table-bordered table-sm">
					<thead>
					<th style='background-color: #4CAF50; color:white'> No. Faktur </th>
					<th style='background-color: #4CAF50; color:white'> No. Reg  </th>
					<th style='background-color: #4CAF50; color:white'> Operasi </th>
					<th style='background-color: #4CAF50; color:white'> Kelas Kamar </th>
					<th style='background-color: #4CAF50; color:white'> Cito </th>
					<th style='background-color: #4CAF50; color:white'> Harga Jual </th>
					<th style='background-color: #4CAF50; color:white'> Petugas Input </th>
					<th style='background-color: #4CAF50; color:white'> Waktu </th>
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($perintah))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['no_reg'] ."</td>
					<td>". $data1['nama_operasi'] ."</td>
					<td>". $data1['kelas_kamar'] ."</td>
					<td>". $data1['nama_cito'] ."</td>
					<td>". $data1['harga_jual'] ."</td>
					<td>". $data1['petugas_input'] ."</td>
					<td>". $data1['waktu'] ."</td>";

					echo"</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
</div>