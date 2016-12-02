<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_seluruh_kategori.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$select = $db->query("SELECT SUM(dp.subtotal) AS total,dp.kode_barang,b.kategori,dp.nama_barang,dp.no_faktur,dp.jumlah_barang FROM detail_penjualan dp LEFT JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' GROUP BY b.kategori");

$take = $db->query("SELECT SUM(dp.subtotal) AS total FROM detail_penjualan dp LEFT JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'");

while ($out = mysqli_fetch_array($take))
{
	$jumlah_total = $out['total'];
}

?>

<h3><b><center>Data Seluruh Kategori Dari Tanggal :(<?php echo $dari_tanggal ?>) Sampai Tanggal :(<?php echo $sampai_tanggal ?>)</center></b></h3>

    <table id="table_kunjungan_pasien_rj_rm" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

          
            <th style='background-color: #4CAF50; color:white'> Kategori </th>
			<th style='background-color: #4CAF50; color:white'> Nilai </th>


</thead>
<tbody>
<?php  

		while($data = mysqli_fetch_array($select))
		{
			
			echo "<tr>

			
			<td>". $data['kategori'] ."</td>
			<td>". rp($data['total']) ."</td>";

			echo "</tr>";
		}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      
<br>
<table>
<tbody>

	<tr><td><b> Total Nilai </b></td> <td>=</td> <td> <b> Rp. <?php echo rp($jumlah_total) ?> </b> </td></tr>

</tbody>
</table>
<br>

</div> <!-- penutup table responsive -->
