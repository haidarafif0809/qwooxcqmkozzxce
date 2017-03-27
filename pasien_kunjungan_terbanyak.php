
<table border="1">
	<thead>
		<th>No RM</th>
		<th>Nama</th>
		<th>Alamat</th>
		<th>Hp </th>
		<th>Umur</th>
		<th>Jumlah Kunjungan</th>	
	</thead>
	<tbody>
		
<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$query_registrasi = $db->query("SELECT no_rm,nama_pasien,alamat_pasien,hp_pasien,umur_pasien, COUNT(*) AS jumlah_berobat FROM registrasi WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND status = 'Sudah Pulang' GROUP BY no_rm ORDER BY jumlah_berobat DESC  ");



while ($data_registrasi = mysqli_fetch_array($query_registrasi)) {
	# code...

	echo "<tr>
	<td>".$data_registrasi['no_rm']."</td>
	<td>".$data_registrasi['nama_pasien']."</td>
	<td>".$data_registrasi['alamat_pasien']."</td>
	<td>".$data_registrasi['hp_pasien']."</td>
		<td>".$data_registrasi['umur_pasien']."</td>
	<td>".$data_registrasi['jumlah_berobat']."</td>
			
	</tr>";
}
 ?>


	</tbody>

</table>