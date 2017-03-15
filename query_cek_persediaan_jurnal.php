<table border="1">
	<thead>
		<th>No Faktur</th>
		<th>Waktu</th>
		<th>Nilai Persediaan Seharusnya </th>
		<th>Nilai Persediaan Jurnal</th>
		<th>Selisih</th>

	</thead>
<tbody>

<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$query_jurnal_persediaan = $db->query("SELECT no_faktur,debit,kredit ,waktu_jurnal FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) = '$sampai_tanggal' GROUP BY no_faktur  ");


while ($data_jurnal_persediaan = mysqli_fetch_array($query_jurnal_persediaan)) {
	# code...
	if ($data_jurnal_persediaan['debit'] != 0) {
		# code...
		$query_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_nilai FROM hpp_masuk WHERE no_faktur = '$data_jurnal_persediaan[no_faktur]'");
		$data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

		$nilai_persediaan_asli = $data_hpp_masuk['total_nilai'];
		$nilai_persediaan_jurnal = $data_jurnal_persediaan['debit'];
		$selisih_nilai_persediaan = $nilai_persediaan_asli - $nilai_persediaan_jurnal;
	}
	else {

		$query_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_nilai FROM hpp_keluar WHERE no_faktur = '$data_jurnal_persediaan[no_faktur]'");
		$data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar);

		$nilai_persediaan_asli = $data_hpp_keluar['total_nilai'];

		$nilai_persediaan_jurnal = $data_jurnal_persediaan['kredit'];

		$selisih_nilai_persediaan = $nilai_persediaan_asli - $nilai_persediaan_jurnal;
	}

	echo "<tr>
	<td>".$data_jurnal_persediaan['no_faktur']."</td>
	<td>".$data_jurnal_persediaan['waktu_jurnal']."</td>
	<td>".$nilai_persediaan_asli."</td>
	<td>".$nilai_persediaan_jurnal."</td>
	<td>".$selisih_nilai_persediaan."</td>

	</tr>";
}



 ?>

 </tbody>
</table>