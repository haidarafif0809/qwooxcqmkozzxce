<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT dpp.id, dpp.no_faktur_pembayaran, dpp.no_faktur_penjualan, dpp.tanggal, dpp.tanggal_jt, dpp.kredit, dpp.potongan, dpp.total, dpp.jumlah_bayar, dpp.kode_pelanggan, p.nama_pelanggan, pp.dari_kas, pp.total, da.nama_daftar_akun FROM detail_pembayaran_piutang dpp INNER JOIN pelanggan p ON dpp.kode_pelanggan = p.kode_pelanggan INNER JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun WHERE dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal'");



 ?>

	<style>
	
	tr:nth-child(even){background-color: #f2f2f2}
	
	</style>

<div class="card card-block">
<h4><center><b>Data Pembayaran Piutang <br>Dari Tanggal (<?php echo $dari_tanggal ?>) Sampai Tanggal (<?php echo $sampai_tanggal ?>)</b></center></h4>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Pembayaran</th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Penjualan</th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
			<th style="background-color: #4CAF50; color: white;"> Cara Bayar </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				
			echo "<tr>
			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['no_faktur_penjualan'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td> ". $data1['kode_pelanggan'] ." - ". $data1['nama_pelanggan'] ."</td>
			<td>". $data1['nama_daftar_akun'] ."</td>
			<td>". $data1['potongan'] ."</td>
			<td>". rp($data1['jumlah_bayar']) ."</td>

			
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>
</div>
<br>

<div class="row">
	
		<a href='cetak_lap_pembayaran_piutang_rekap.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembayaran Piutang </a>
	
		<a href='download_lap_pembayaran_piutang.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-primary'><i class='fa fa-download'> </i> Download Excel </a>

</div>

       

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>