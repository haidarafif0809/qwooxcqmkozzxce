<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_reg = stringdoang($_POST['no_reg']);
$sub_operasi = stringdoang($_POST['sub_operasi']);
$operasi = stringdoang($_POST['operasi']);

$detail = $db->query("SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg WHERE hdo.id_sub_operasi = '$sub_operasi' AND hdo.no_reg = '$no_reg' ");

?>
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>
<div class="container">				
<div class="table-responsive"> 
<table id="table" class="table table-bordered">
	<thead>

	<th style="background-color: #4CAF50; color: white;"> No. Faktur </th>
	<th style="background-color: #4CAF50; color: white;"> No. Reg </th>
	<th style="background-color: #4CAF50; color: white;"> Operasi </th>
	<th style="background-color: #4CAF50; color: white;"> Petugas Operasi </th>
	<th style="background-color: #4CAF50; color: white;"> Petugas Input </th>
	<th style="background-color: #4CAF50; color: white;"> Waktu </th>
					
					
	</thead>
					
	<tbody>
	

	<?php
					
					//menyimpan data sementara yang ada pada $perintah
	while ($data = mysqli_fetch_array($detail))
	{
		
					echo "<tr>
					<td>". $data['no_faktur'] ."</td>
					<td>". $data['no_reg'] ."</td>
					<td>". $data['nama_detail_operasi'] ."</td>
					<td>". $data['petugas_ops'] ."</td>
					<td>". $data['petugas_input'] ."</td>
					<td>". $data['waktu'] ."</td>

					</tr>";
					}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
</tbody>
					
</table>
</div>
</div>

					<script>
		
		$(document).ready(function(){
		$('#table').DataTable(
			{"ordering": false});
		});
		</script>