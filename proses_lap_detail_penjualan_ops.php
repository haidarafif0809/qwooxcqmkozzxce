<?php session_start();


include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$detail = $db->query("SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg WHERE DATE(hdo.waktu) >= '$dari_tanggal' AND DATE(hdo.waktu) <= '$sampai_tanggal' ");


 ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>



  <br><br>

<div class="card card-block">
 <h3><center>Data Seluruh Detail Operasi Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
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

<br>

       <a href='cetak_lap_detail_operasi.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank' ><i class='fa fa-print'> </i> Cetak Detail Laporan Operasi </a>
       <a href='export_lap_detail_operasi.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' type='submit' class='btn btn-default'> <i class='fa fa-cloud-download'> </i> Download Excel</a>
</div>


		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script>


<?php 
include 'footer.php';
 ?>