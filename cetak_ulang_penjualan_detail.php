<?php session_start();
include 'header.php';
include 'db.php';
include 'sanitasi.php';


$nama_petugas = $_SESSION['nama'];


$id = stringdoang($_GET['id']);
$no_faktur = stringdoang($_GET['no_faktur']);



$cek_nama_perusahaan = $db->query("SELECT * FROM perusahaan");
$keluar = mysqli_fetch_array($cek_nama_perusahaan);
$nama_perusahaan = $keluar['nama_perusahaan'];
$alamat_perusahaan = $keluar['alamat_perusahaan'];
$no_telp = $keluar['no_telp'];

$cek_pembelian = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
$jumlah_beli = mysqli_num_rows($cek_pembelian);

$cek_total = $db->query("SELECT * FROM penjualan WHERE id = '$id' ");
$keluar = mysqli_fetch_array($cek_total);
$total_penjualan  = $keluar['total'];
$diskon  = $keluar['potongan'];
$tax  = $keluar['tax'];
$bayar  = $keluar['tunai'];
$tgl = $keluar['tanggal'];
$no_rm = $keluar['kode_pelanggan'];
$nama = $keluar['nama'];

$sisa = $bayar - $total_penjualan;


$gear = $db->query("SELECT nama_print,status_print FROM setting_printer WHERE nama_print = 'Printer Struk' ");
$ggo = mysqli_fetch_array($gear);
$printer = $ggo['status_print'];

?>


<html>
<head>
	<title>
	</title>
</head>
<body>
<?php echo $nama_perusahaan;?><br>
<?php echo $alamat_perusahaan;?><br>
=================================<br>
<table>
	<tbody>
		<tr>
<td>No RM </td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_rm;?></td></tr><tr>
<td>Nama Pasien </td><td>&nbsp;:&nbsp;</td><td> <?php echo $nama;?></td>
		</tr>
	</tbody>
</table>
=================================<br>
<table>
	<tbody>
		<tr>
<td>No Faktur</td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_faktur;?></td></tr><tr>
<td>Kasir </td><td>&nbsp;:&nbsp;</td><td> <?php echo $nama_petugas;?></td>
		</tr>
	</tbody>
</table>
=================================<br>




<table>
	<tbody>
<?php 
while($data = mysqli_fetch_array($cek_pembelian))
{
	
		
			echo "<tr>
			<td>$data[nama_barang]</td>
			<td style='padding:3px'>$data[harga]</td>
			<td style='padding:3px'>$data[jumlah_barang]</td>
			<td style='padding:3px'>$data[subtotal] </td>
			</tr>";
		


}
?>



	</tbody>
</table>
=================================<br>
<table>
	<tbody>

<?php 
if ($diskon == ''){


	
			echo 	
		"<tr><td>Diskon (-)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".$diskon."</td></tr>
			<tr><td>Pajak (+)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".$tax." </td></tr>
                    <tr><td>Biaya Admin (+)</td> </td><td>&nbsp;:&nbsp;</td><td>".rp($keluar['biaya_admin'])." </td></tr>

	";
}

elseif ($tax == ''){
echo "
			<tr><td>Diskon (-)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".$diskon."</td></tr>
			<tr><td>Pajak (+)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".$tax." </td></tr>
                    <tr><td>Biaya Admin (+)</td> </td><td>&nbsp;:&nbsp;</td><td>".rp($keluar['biaya_admin'])." </td></tr>

	";
}

elseif ($diskon > 0 ){
echo "
			<tr><td>Diskon (-)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".rp($diskon)."</td></tr>
			<tr><td>Pajak (+)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".rp($tax)." </td></tr>
                    <tr><td>Biaya Admin (+)</td> </td><td>&nbsp;:&nbsp;</td><td>".rp($keluar['biaya_admin'])." </td></tr>

	";
}

elseif ($tax > 0 ){
echo "
			<tr><td>Diskon (-)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".rp($diskon)."</td></tr>
			<tr><td>Pajak (+)</td><td>&nbsp;:&nbsp;&nbsp;</td> <td>".rp($tax) ." </td></tr>
                    <tr><td>Biaya Admin (+)</td> </td><td>&nbsp;:&nbsp;</td><td>".rp($keluar['biaya_admin'])." </td></tr>


		";
}
?>

</tbody>
</table>

<table>
	<tbody>
		
			<tr><td>Total Item </td> <td>&nbsp;:&nbsp;</td> <td>(<?php echo $jumlah_beli;?>)&nbsp;</td><td><?php echo rp($total_penjualan);?></td></tr>
			<tr><td>Tunai</td> <td>&nbsp;:&nbsp;</td> <td>&nbsp;</td><td><?php echo rp($bayar);?> </td></tr>
			<tr><td>Kembalian</td> <td>&nbsp;:&nbsp;</td><td>&nbsp;</td> <td><?php echo rp($sisa);?></td></tr>

		
	</tbody>
</table>
=================================<br>
Tanggal : <?php echo $tgl;?><br>
=================================<br>
Terima Kasih <br>
Semoga Lekas Sembuh<br>
Telp : <?php echo $no_telp;?><br>
</body>
</html>

<script>
$(document).ready (function(){

    window.print();
});
</script>