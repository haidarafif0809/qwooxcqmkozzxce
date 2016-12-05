<?php

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kunjungan_pasien_ri_berdasarkan_rm_dan_tanggal.xls");

include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_GET['no_rm']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$take_rm = $db->query("SELECT no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,alamat_pasien,penjamin,hp_pasien,tanggal FROM registrasi WHERE no_rm = '$no_rm' AND jenis_pasien = 'Rawat Inap' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

?>

<h3>
<b>
<center>
Data Kunjungan Pasien Rawat Inap No RM <?php echo $no_rm; ?> Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?>
</center>
</b>
</h3>

<table id="kunjungan_ri_rm" class="table table-bordered">

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

</thead>
<tbody>
<?php  

		while($data = mysqli_fetch_array($take_rm))
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
			<td>". $data['tanggal'] ."</td>";
			
			echo "</tr>";
		}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      
