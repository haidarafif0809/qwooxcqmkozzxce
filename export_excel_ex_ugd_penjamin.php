<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kunjungan_pasien_ugd_berdasarkan_tanggal.xls");

include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_GET['penjamin']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$take_ugd = $db->query("SELECT r.id,r.no_rm,r.no_reg,r.nama_pasien,r.jenis_kelamin,r.umur_pasien,r.alamat_pasien,r.penjamin,r.hp_pasien,r.tanggal FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg WHERE r.penjamin = '$penjamin' AND  r.tanggal >= '$dari_tanggal' AND r.tanggal <= '$sampai_tanggal' AND r.jenis_pasien = 'UGD'");

$query01 = $db->query("SELECT SUM(p.total) AS total_penjualan FROM penjualan p INNER JOIN registrasi r ON p.no_reg = r.no_reg WHERE r.jenis_pasien = 'UGD' AND p.penjamin = '$penjamin' AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total = $cek01['total_penjualan'];

?>

<h3>
<b>
<center>
Data Kunjungan Pasien Periode <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?>
</center>
</b>
</h3>

<table id="kunjungan_rj_rm" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th style='background-color: #4CAF50; color:white'> No RM </th>
			<th style='background-color: #4CAF50; color:white'> No REG </th>
			<th style='background-color: #4CAF50; color:white'> Nama Pasien </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Kelamin </th>
			<th style='background-color: #4CAF50; color:white'> Umur </th>
			<th style='background-color: #4CAF50; color:white'> Alamat Pasien </th>
			<th style='background-color: #4CAF50; color:white'> Penjamin </th>
			<th style='background-color: #4CAF50; color:white'> No Handphone </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Periksa </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>

</thead>
<tbody>
<?php  

		while($data = mysqli_fetch_array($take_ugd))
		{
			
			echo "<tr>

			<td>". $data['no_rm'] ."</td>
			<td>". $data['no_reg'] ."</td>
			<td>". $data['nama_pasien'] ."</td>
			<td>". $data['jenis_kelamin'] ."</td>
			<td>". $data['umur_pasien'] ."</td>
			<td>". $data['alamat_pasien'] ."</td>
			<td>". $data['penjamin'] ."</td>
			<td>". $data['hp_pasien'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>". $data['total'] ."</td>";
			
			echo "</tr>";
		}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
<div class="col-sm-6">
    		<h4>Penjamin : <b><?php echo $penjamin; ?></b></h4>
    		<h4>Jumlah Total : <b><?php echo rp($total); ?></b></h4>
    	</div>


        </tbody>
    </table>      
