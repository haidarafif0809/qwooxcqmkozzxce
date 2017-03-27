<?php 

include 'sanitasi.php';
include 'header.php';
include 'db.php';


$tanggal = stringdoang($_GET['tanggal']);
$daftar_akun = stringdoang($_GET['daftar_akun']);
$rekap = stringdoang($_GET['rekap']);


	$inner_join = $db->query("SELECT j.kode_akun_jurnal, d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.kode_akun_jurnal = '$daftar_akun'");
	$ambil = mysqli_fetch_array($inner_join);
	$nama_akun = $ambil['nama_daftar_akun'];

	$sum_saldo1 = $db->query("SELECT SUM(debit) - SUM(kredit) AS saldo FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$tanggal' AND kode_akun_jurnal = '$daftar_akun'");
	$cek_saldo1 = mysqli_fetch_array($sum_saldo1);
	$saldo = $cek_saldo1['saldo'];

	$total_debit = 0;
	$total_kredit = 0;

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-">
        </div>
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='110`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h2> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h2> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 

<hr>

                 <h3>Cetak Buku Besar Per Tanggal</h3>
                 </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<hr>

<div class="container">
<div class="col-sm-10">
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

						$total_debit += $cek['debit'];
						$total_kredit += $cek['kredit'];

						echo "<tr>
						<td><center> <b>-</b> </center></td>
						<td>Direkap Per Hari</td>
						<td>". tanggal($cek['waktu_jurnal']) ."</td>
						<td>". rp($cek['debit']) ."</td>
						<td>". rp($cek['kredit']) ."</td>";


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
						$saldo = $saldo + $cek['debit'] - $cek['kredit'];

						$total_debit += $cek['debit'];
						$total_kredit += $cek['kredit'];


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

</div>
     
	
<?php include 'footer.php'; ?>