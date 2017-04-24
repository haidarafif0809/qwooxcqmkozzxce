<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];


$query_piutang = $db->query("SELECT no_faktur_pembayaran, kode_pelanggan, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");

?>
					<div class="container">
					
					<div class="table-responsive">
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur Pembayaran</th>
					<th> Kode Pelanggan </th>
					<th> Nomor Faktur Penjualan </th>
					<th> Tanggal </th>
					<th> Tanggal Jatuh Tempo </th>
					<th> Kredit </th>
					<th> Potongan </th>
					<th> Total </th>
					<th> Jumlah Bayar </th>
					</thead>
					
					
					<tbody>
					
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data_piutang = mysqli_fetch_array($query_piutang))
					{

					$query_pasien = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data_piutang[kode_pelanggan]'");
					$data_pasien = mysqli_fetch_array('$query_pasien');

					echo "SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data_piutang[kode_pelanggan]'";
					//menampilkan data
					echo "<tr>
					<td>". $data_piutang['no_faktur_pembayaran'] ."</td>
					<td>". $data_piutang['kode_pelanggan'] ." - ". $data_pasien['nama_pelanggan'] ."</td>
					<td>". $data_piutang['no_faktur_penjualan'] ."</td>
					<td>". $data_piutang['tanggal'] ."</td>
					<td>". $data_piutang['tanggal_jt'] ."</td>
					<td>". $data_piutang['kredit'] ."</td>
					<td>". rp($data_piutang['potongan']) ."</td>
					<td>". rp($data_piutang['total']) ."</td>
					<td>". rp($data_piutang['jumlah_bayar']) ."</td>
					</tr>";
					}
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 					
					?>
					
					</tbody>
					</table>
					</div>
					</div>