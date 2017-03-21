<?php 

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<form>
<input type="text" name="dari_tanggal" value="<?php echo $dari_tanggal ?>">
<input type="text" name="sampai_tanggal" value="<?php echo $sampai_tanggal ?>">
	<input type="submit" name="terapkan" value="Terapkan">
</form>

<p><b>Catatan:</b> Jika jumlah produk nya 0 atau tidak ada dan master fee produk nya 0 atau tidak ada , maka jumlah fee yang baru nya tidak akan di terapkan. jadi harus cek dulu, apakah benar master data fee produk untuk petugas tersebut benar 0 atau tidak.</p>

<br>
<table border="1">
	<thead>
	<th>Tanggal</th>
	<th>No Faktur</th>
	<th>Kode Produk</th>
	<th>Petugas</th>
	<th>Jumlah Fee Lama</th>
	<th>Jumlah Produk Yang di jual</th>
	<th>Master Fee Produk</th>
	<th>Jumlah Fee Baru</th>
	</thead>
	<tbody>
<?php 



$query_komisi_penjualan = $db->query("SELECT no_faktur,tanggal,jumlah_fee ,kode_produk ,nama_petugas, user.nama FROM laporan_fee_produk LEFT JOIN user  ON user.id = laporan_fee_produk.nama_petugas WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");  
 
 while ($data_komisi_penjualan = mysqli_fetch_array($query_komisi_penjualan)) {
 	
 	$query_master_komisi_produk = $db->query("SELECT jumlah_uang FROM fee_produk WHERE kode_produk = '$data_komisi_penjualan[kode_produk]' AND nama_petugas = '$data_komisi_penjualan[nama_petugas]'");
 	$data_master_komisi_produk = mysqli_fetch_array($query_master_komisi_produk);

 	$query_jumlah_penjualan = $db->query("SELECT jumlah_barang FROM detail_penjualan WHERE kode_barang = '$data_komisi_penjualan[kode_produk]' AND no_faktur = '$data_komisi_penjualan[no_faktur]'");
 	$data_jumlah_penjualan = mysqli_fetch_array($query_jumlah_penjualan);

 	$jumlah_komisi_terbaru = $data_master_komisi_produk['jumlah_uang'] * $data_jumlah_penjualan['jumlah_barang'];

 	if (isset($_GET['terapkan']) AND ( $data_master_komisi_produk['jumlah_uang'] != 0 AND $data_master_komisi_produk['jumlah_uang'] != '' AND $data_jumlah_penjualan['jumlah_barang'] != ''  )) {
 		
 		$update_komisi_penjualan = $db->query("UPDATE laporan_fee_produk SET jumlah_fee = '$jumlah_komisi_terbaru' WHERE kode_produk = '$data_komisi_penjualan[kode_produk]' AND no_faktur = '$data_komisi_penjualan[no_faktur]' AND nama_petugas = '$data_komisi_penjualan[nama_petugas]' ");

 	}

 	echo "<tr>
 	<td>".$data_komisi_penjualan['tanggal']."</td>
 	<td>".$data_komisi_penjualan['no_faktur']."</td>
 	<td>".$data_komisi_penjualan['kode_produk']."</td>
 	<td>".$data_komisi_penjualan['nama']."</td>
 	<td>".$data_komisi_penjualan['jumlah_fee']."</td>

 	<td>".$data_jumlah_penjualan['jumlah_barang']."</td>
 	<td>".$data_master_komisi_produk['jumlah_uang']."</td>

 	<td>".$jumlah_komisi_terbaru."</td>
 	</tr>";

 }
 ?>
</tbody>
</table>


</body>
</html>