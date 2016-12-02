<?php session_start();


include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT p.no_faktur,kk.nama AS kelas_kamar,c.nama AS nama_cito,u.nama AS petugas_input,o.nama_operasi,ho.no_reg,ho.harga_jual,ho.waktu,ho.id,ho.sub_operasi,ho.operasi FROM hasil_operasi ho INNER JOIN operasi o ON ho.operasi = o.id_operasi INNER JOIN user u ON ho.petugas_input = u.id INNER JOIN sub_operasi so ON ho.sub_operasi = so.id_sub_operasi INNER JOIN cito c ON so.id_cito = c.id INNER JOIN kelas_kamar kk ON so.id_kelas_kamar = kk.id INNER JOIN penjualan p ON ho.no_reg = p.no_reg WHERE DATE(ho.waktu) >= '$dari_tanggal' AND DATE(ho.waktu) <= '$sampai_tanggal' ");


 ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Operasi</h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

  <br><br>

<div class="card card-block">
 <h3><center>Data Seluruh Operasi Dari Tanggal <?php echo tanggal_terbalik($dari_tanggal) ?> Sampai Tanggal <?php echo tanggal_terbalik($sampai_tanggal) ?></center></h3>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> No. Faktur </th>
					<th style="background-color: #4CAF50; color: white;"> No. Reg  </th>
					<th style="background-color: #4CAF50; color: white;"> Operasi </th>
					<th style="background-color: #4CAF50; color: white;"> Kelas Kamar </th>
					<th style="background-color: #4CAF50; color: white;"> Cito </th>
					<th style="background-color: #4CAF50; color: white;"> Harga Jual </th>
					<th style="background-color: #4CAF50; color: white;"> Petugas Input </th>
					<th style="background-color: #4CAF50; color: white;"> Waktu </th>
					<th style="background-color: #4CAF50; color: white;"> Detail </th>
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
					echo "<td><button class='btn btn-floating bnt-lg  btn-info detail-lap-ops' data-id='". $data1['id']."'
					data-sub_operasi='". $data1['sub_operasi']."' data-operasi='". $data1['operasi']." data-no_faktur='". $data1['no_faktur']." data-no_reg='". $data1['no_reg']."'><i class='fa fa-list'></i></button></td>";

					echo"</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
</div>

<br>

       <a href='cetak_lap_operasi.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank' ><i class='fa fa-print'> </i> Cetak Laporan Operasi </a>

       <a href='export_lap_operasi.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' type='submit' class='btn btn-default'> <i class='fa fa-cloud-download'> </i> Download Excel</a>

</div>


		<script type="text/javascript">
		
		$(".detail-lap-ops").click(function(){
		var sub_operasi = $(this).attr('data-sub_operasi');
		var operasi = $(this).attr('data-operasi');
		var no_faktur = $(this).attr('data-no_faktur');
		var no_reg = $(this).attr('data-no_reg');

		
		$("#modal_detail").modal('show');
		
		$.post('proses_lap_detail_operasi.php',{sub_operasi:sub_operasi,operasi:operasi,no_faktur:no_faktur,no_reg:no_reg},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>


		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script>


<?php 
include 'footer.php';
 ?>