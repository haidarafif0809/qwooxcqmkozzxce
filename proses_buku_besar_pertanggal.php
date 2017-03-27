	<?php 


	include 'sanitasi.php';
	include 'db.php';


	$tanggal = stringdoang($_POST['tanggal']);
	$daftar_akun = stringdoang($_POST['daftar_akun']);
	$rekap = stringdoang($_POST['rekap']);


	$sum_saldo1 = $db->query("SELECT SUM(debit) - SUM(kredit) AS saldo FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$tanggal' AND kode_akun_jurnal = '$daftar_akun'");
	$cek_saldo1 = mysqli_fetch_array($sum_saldo1);

	$saldo = $cek_saldo1['saldo'];
	$total_debit = 0;
	$total_kredit = 0;


	 ?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="card card-block">

	<?php if ($rekap == "direkap_perhari"): ?>
	<h3> Tanggal : <?php echo tanggal($tanggal); ?> </h3>
	<br>

	 <table id="tableuser1" class="table table-hover">
	            <thead>
				<th> No Faktur </th>
				<th> Keterangan </th>
				<th> Tanggal </th>
				<th> Debet </th>
				<th> Kredit </th>
				<th> Saldo </th>


				
			</thead>
			
			<tbody>

				<tr style="color:blue">
				<td></td>
				<td>Saldo Awal</td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				</tr>

				<?php 

	$select = $db->query("SELECT DATE(waktu_jurnal) AS waktu_jurnal, no_faktur, keterangan_jurnal, SUM(debit) AS debit, SUM(kredit) AS kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$daftar_akun' GROUP BY DATE(waktu_jurnal) ORDER BY waktu_jurnal ASC");
	


				//menyimpan data sementara yang ada pada $perintah
				while ($cek = mysqli_fetch_array($select))

				{

				
								
						
						echo "<tr>
						<td><center> <b>-</b> </center></td>
						<td>Direkap Per Hari</td>
						<td>". tanggal($cek['waktu_jurnal']) ."</td>
						<td>". rp($cek['debit']) ."</td>
						<td>". rp($cek['kredit']) ."</td>";

						$total_debit += $cek['debit'];
						$total_kredit += $cek['kredit'];

						$saldo = $saldo + $cek['debit'] - $cek['kredit'];

						echo "<td>". rp($saldo) ."</td></tr>";
						

						
						


				}



				echo "<tr style='color:red'>
				<td></td>
				<td></td>
				<td><b>TOTAL :</b></td>
				<td><b>". rp($total_debit) ."</b></td>
				<td><b>". rp($total_kredit) ."</b></td>
				<td><b>". rp($saldo) ."</b></td>

				</tr>";	
				mysqli_close($db);
			?>
			</tbody>

		</table>
	<?php endif ?>

	<?php if ($rekap == "tidak_direkap_perhari" || $rekap == ""): ?>
	<h3> Periode : <?php echo tanggal($tanggal); ?></h3>
	<br>

	 <table id="tableuser2" class="table table-hover">
	            <thead>
				<th> No Faktur </th>
				<th> Keterangan </th>
				<th> Tanggal </th>
				<th> Debet </th>
				<th> Kredit </th>
				<th> Saldo </th>


				
			</thead>
			
			<tbody>

				<tr style="color:blue">
				
				
				
				<td>Saldo Awal</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				</tr>

				<?php 

	$select = $db->query("SELECT DATE(waktu_jurnal) AS waktu_jurnal, no_faktur, keterangan_jurnal, debit, kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$daftar_akun' ORDER BY waktu_jurnal ASC");
	


				//menyimpan data sementara yang ada pada $perintah
				while ($cek = mysqli_fetch_array($select))

				{		
						
						echo "<tr>
						<td>". $cek['no_faktur']."</td>
						<td>". $cek['keterangan_jurnal']."</td>
						<td>". tanggal($cek['waktu_jurnal']) ."</td>
						<td>". rp($cek['debit']) ."</td>
						<td>". rp($cek['kredit']) ."</td>";

						
						$total_debit += $cek['debit'];
						$total_kredit += $cek['kredit'];
						
						$saldo = $saldo + $cek['debit'] - $cek['kredit'];

						echo "<td>". rp($saldo) ."</td></tr>";
						


				}

				echo "<tr style='color:red'>
				<td><b>TOTAL :</b></td>
				<td></td>
				<td></td>
				<td><b>". rp($total_debit) ."</b></td>
				<td><b>". rp($total_kredit) ."</b></td>
				<td><b>". rp($saldo) ."</b></td>

				</tr>";	
				mysqli_close($db);
			?>
			</tbody>

		</table>	
	<?php endif ?>



		<br><br>

	       <a href='cetak_laporan_buku_besar_pertanggal.php?tanggal=<?php echo $tanggal; ?>&daftar_akun=<?php echo $daftar_akun; ?>&rekap=<?php echo $rekap; ?>'
	       class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Buku Besar </a>
	     
</div>

	<script>
	// untuk memunculkan data tabel 
	$(document).ready(function(){
	    $('#tableuser1').DataTable({'ordering':false});


	});
	  
	</script>

	<script>
	// untuk memunculkan data tabel 
	$(document).ready(function(){
	    $('#tableuser2').DataTable({'ordering':false});


	});
	  
	</script>
