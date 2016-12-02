<?php 
include 'db.php';
include 'sanitasi.php';


$no_rm = stringdoang($_POST['no_rm']);

$take_rm = $db->query("SELECT no_rm,no_reg,nama_pasien,jenis_kelamin,umur_pasien,alamat_pasien,penjamin,hp_pasien,tanggal,menginap,bed,group_bed FROM registrasi WHERE no_rm = '$no_rm' AND jenis_pasien = 'Rawat Inap'");

 ?>


<div class="container">
    <table id="table_kunjungan_pasien_ri_rm" class="table table-bordered table-sm">

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
			<th style='background-color: #4CAF50; color:white'> Kode Kamar </th>
			<th style='background-color: #4CAF50; color:white'> Nama Kamar </th>
			<th style='background-color: #4CAF50; color:white'> Lama Menginap </th>

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
			<td>". $data['bed'] ."</td>
			<td>". $data['group_bed'] ."</td>
			<td>". $data['menginap'] ."</td>
			
			<td> <a href='detail_lap_kunjungan_ri_rm.php?no_rm=".$data['no_rm']."&no_reg=".$data['no_reg']."' class='btn-floating btn-info btn-small'> 
			<i class='fa fa-archive'></i> </a> </td>";

			echo "</tr>";
		}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!-- penutup table responsive -->

<a href='export_excel_kunjungan_pasien_rm_ri.php?no_rm=<?php echo $no_rm; ?>' type='submit' class='btn btn-warning btn-lg'>Download Excel</a>

</div> <!--Closed Container-->


<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table_kunjungan_pasien_ri_rm').DataTable({"ordering":false});
    });

</script>
