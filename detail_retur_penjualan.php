<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur_retur = $_POST['no_faktur_retur'];

 $query = $db->query("SELECT drp.no_faktur_retur,drp.no_faktur_penjualan,drp.nama_barang,drp.kode_barang,drp.jumlah_beli,drp.jumlah_retur,drp.harga,drp.potongan,drp.tax,drp.subtotal,drp.satuan,s.nama,ss.nama AS satuan_jual FROM detail_retur_penjualan drp INNER JOIN satuan s ON drp.satuan = s.id INNER JOIN satuan ss ON drp.asal_satuan = ss.id WHERE no_faktur_retur = '$no_faktur_retur' ");


 ?>


<div class="container">



        
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur Retur </th>
			<th> Nomor Faktur Penjualan </th>
			<th> Nama Barang </th>
			<th> Kode Barang </th>
			<th> Jumlah Jual </th>
			<th> Jumlah Retur </th>
			<th> Satuan Retur </th>
			<th> Harga </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Subtotal </th>
			

			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query))
			{

			$ss = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$data1[kode_barang]' AND id_satuan = '$data1[satuan]' ");
			$cek = mysqli_num_rows($ss);
			$sid = mysqli_fetch_array($ss);
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['no_faktur_penjualan'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". rp($data1['jumlah_beli']) ." ". $data1['satuan_jual'] ."</td>";

			if ($cek > 0) {
				$jumlah_produk = $data1['jumlah_retur'] / $sid['konversi'];
				echo "<td>". $jumlah_produk  ."</td>";
			}
			else{
				echo "<td>". rp($data1['jumlah_retur']) ."</td>";
			}

			echo "

			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>

		";


			echo "</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>


</div><!--end of container-->
