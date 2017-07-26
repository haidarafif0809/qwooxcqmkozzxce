<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$id = stringdoang($_POST['id']);
$kode_produk = stringdoang($_POST['kode']);

?>

<div class="container">		
	<div class="table-responsive"> 

		<div class="row">
			<div class="col-sm-6 harga-rajal">
				<h5><b>Harga Jual Rawat Jalan</b></h5><hr>
				<table id="table-rajal" class="table table-bordered table-sm">
					<thead>
						<th> Harga 1 </th>
						<th> Harga 2 </th>
						<th> Harga 3 </th>
						<th> Harga 4 </th>
						<th> Harga 5 </th>
						<th> Harga 6 </th>
						<th> Harga 7 </th>
					</thead>

					<tbody>
					<?php

					$query_harga_produk_rj = $db->query("SELECT harga_jual, harga_jual2, harga_jual3, harga_jual4, harga_jual5, harga_jual6, harga_jual7 FROM barang WHERE id = '$id'");
					while ($data_produk = mysqli_fetch_array($query_harga_produk_rj)){

						echo "<tr>
								<td style='text-align:right'>". rp($data_produk['harga_jual'])."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual2']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual3']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual4']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual5']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual6']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual7']) ."</td>
							</tr>";
					}

					?>
					</tbody>
				</table>
			</div>

			<div class="col-sm-6 harga-ranap">
				<h5><b>Harga Jual Rawat Inap</b></h5><hr>
				<table id="table-ranap" class="table table-bordered table-sm">
					<thead>
						<th> Harga 1 </th>
						<th> Harga 2 </th>
						<th> Harga 3 </th>
						<th> Harga 4 </th>
						<th> Harga 5 </th>
						<th> Harga 6 </th>
						<th> Harga 7 </th>
					</thead>

					<tbody>
					<?php

					$query_harga_produk_ri = $db->query("SELECT harga_jual_inap, harga_jual_inap2, harga_jual_inap3, harga_jual_inap4, harga_jual_inap5, harga_jual_inap6, harga_jual_inap7 FROM barang WHERE id = '$id'");
					while ($data_produk = mysqli_fetch_array($query_harga_produk_ri)){

						echo "<tr>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap'])."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap2']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap3']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap4']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap5']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap6']) ."</td>
								<td style='text-align:right'>". rp($data_produk['harga_jual_inap7']) ."</td>
							</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>