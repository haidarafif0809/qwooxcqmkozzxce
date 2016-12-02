<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_laporan_detail_operasi.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$detail = $db->query("SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg WHERE DATE(hdo.waktu) >= '$dari_tanggal' AND DATE(hdo.waktu) <= '$sampai_tanggal' ");

?>
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>
 <h3><center>Data Seluruh Operasi Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>

 <table id="tableuser" class="table">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> No. Faktur </th>
					<th style="background-color: #4CAF50; color: white;"> No. Reg  </th>
					<th style="background-color: #4CAF50; color: white;"> Operasi </th>
					<th style="background-color: #4CAF50; color: white;"> Petugas Operasi </th>
					<th style="background-color: #4CAF50; color: white;"> Petugas Input </th>
					<th style="background-color: #4CAF50; color: white;"> Waktu </th>
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($detail))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['no_reg'] ."</td>
					<td>". $data1['nama_detail_operasi'] ."</td>
					<td>". $data1['petugas_ops'] ."</td>
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