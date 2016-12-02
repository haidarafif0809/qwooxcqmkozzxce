<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$take_rm = $db->query("SELECT id,no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,alamat_pasien,penjamin,hp_pasien,tanggal FROM registrasi WHERE jenis_pasien = 'Rawat Jalan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

 ?>

<div class="container">
    <table id="table_kunjungan_pasien_rj_rm" class="table table-bordered">

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
			<th style='background-color: #4CAF50; color:white'> Detail </th>

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
			<td>". $data['tanggal'] ."</td>
			
			<td> <a href='detail_lap_kunjungan_rj.php?no_rm=".$data['no_rm']."&no_reg=".$data['no_reg']."'  class='btn-floating btn-info btn-small'> 
			<i class='fa fa-archive'></i> </a> </td>";

			echo "</tr>";
		}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!-- penutup table responsive -->

<a href='export_excel_kunjungan_pasien_tanggal_rj.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' type='submit' class='btn btn-warning btn-lg'>Download Excel</a>

</div> <!--Closed Container-->




<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table_kunjungan_pasien_rj_rm').DataTable({"ordering":false});
    });

</script>

