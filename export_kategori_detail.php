<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_detail_per_kategori.xls");

include 'db.php';
include 'sanitasi.php';

$tenant_detail = stringdoang($_GET['tenant_detail']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$select_barang = $db->query("SELECT kode_barang FROM barang WHERE kategori = '$tenant_detail'");
$jumlah_transaksi = mysqli_num_rows($select_barang);

$select = $db->query("SELECT SUM(dp.subtotal) AS total,dp.no_faktur,dp.tanggal,dp.jam FROM detail_penjualan dp LEFT JOIN barang b ON dp.kode_barang = b.kode_barang WHERE b.kategori = '$tenant_detail' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' GROUP BY dp.no_faktur");
$gived = mysqli_num_rows($select);

$take = $db->query("SELECT SUM(dp.subtotal) AS total,dp.no_faktur,dp.tanggal,dp.jam FROM detail_penjualan dp LEFT JOIN barang b ON dp.kode_barang = b.kode_barang WHERE b.kategori = '$tenant_detail' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'");

while ($out = mysqli_fetch_array($take))
{
	$jumlah_total = $out['total'];
}

?>

<h3><b><center>Data Detail Per Kategori (<?php echo $tenant_detail ?>)
<br>
Dari Tanggal (<?php echo $dari_tanggal ?>) Sampai Tanggal (<?php echo $sampai_tanggal ?>)
</center></b></h3>
<div class="container">


    <table id="table_kunjungan_pasien_rj_rm" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th style='background-color: #4CAF50; color:white'> No Faktur </th>
            <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
            <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
            <th style='background-color: #4CAF50; color:white'> Jumlah Barang </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Nilai </th>


</thead>
<tbody>
<?php  

	while($again = mysqli_fetch_array($select_barang))
	{
		$select_detail_jual = $db->query("SELECT subtotal,no_faktur,kode_barang,
			nama_barang,jumlah_barang,tanggal,jam FROM detail_penjualan 
			WHERE kode_barang = '$again[kode_barang]' ORDER BY no_faktur DESC");

			while($data = mysqli_fetch_array($select_detail_jual))
		{
			echo "<tr>

			<td>". $data['no_faktur'] ."</td>
			<td>". $data['kode_barang'] ."</td>
			<td>". $data['nama_barang'] ."</td>
			<td>". $data['jumlah_barang'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>". $data['jam'] ."</td>
			<td>". rp($data['subtotal']) ."</td>";

			echo "</tr>";
		}

	}
//Untuk Memutuskan Koneksi Ke Database

?>
        </tbody>
    </table>      

</div> <!-- penutup table responsive -->




<br>
<table>
<tbody>

	<tr><td><b> Total No Faktur </b></td> <td>=</td> <td> <b> <?php echo rp($gived) ?> </b> </td></tr>
	<tr><td><b> Total Nilai </b></td> <td>=</td> <td> <b> <?php echo rp($jumlah_total) ?> </b> </td></tr>


</tbody>
</table>
<br>


</div> <!--Closed Container-->

