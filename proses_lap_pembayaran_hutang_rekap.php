<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
/*$perintah = $db->query("SELECT da.nama_daftar_akun, p.no_faktur_pembayaran,p.tanggal,p.nama_suplier,p.dari_kas,p.total,s.nama FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ORDER BY p.id DESC");

$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];*/

$select_query = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");


$select_jumlah = $db->query("SELECT SUM(jumlah_bayar) AS total_akhir 
	FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while ($out = mysqli_fetch_array($select_jumlah))
{
$total_akhir = $out['total_akhir'];
}

 ?>

<style>
	
	tr:nth-child(even){background-color: #f2f2f2}
	
	</style>

<div class='container'>
	

<div class="card card-block">
<h3><center><b>Data Pembayaran Hutang <br>Dari Tanggal (<?php echo $dari_tanggal ?>) Sampai Tanggal (<?php echo $sampai_tanggal ?>)</b></center></h3>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>

			<th style="background-color: #4CAF50; color: white;"> No Faktur Bayar</th>
			<th style="background-color: #4CAF50; color: white;"> No Faktur Beli</th>
			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jatuh Tempo </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Total Hutang </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($select_query))
			{
		$suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$data1[suplier]'");
        $out = mysqli_fetch_array($suplier);
        if ($data1['suplier'] == $out['id'])
        {
          $out['nama'];
        }
			echo "<tr>
			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['no_faktur_pembelian'] ."</td>
			<td>". $out['nama'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". rp($data1['kredit']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['total']) ."</td>
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


<h4><b>Total :</b> Rp. <?php echo rp($total_akhir); ?></h4>
<br>
  <a href='cetak_lap_pembayaran_hutang_rekap.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembayaran Hutang </a>

  <a href='export_lap_pembayaran_hutang.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-primary'><i class='fa fa-download'> </i> Download Excel </a>

</div>

     

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();

});
  
</script>