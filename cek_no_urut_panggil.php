<?php 
include 'sanitasi.php';
include 'db.php';

$no_urut = angkadoang($_POST['no_urut']);
$poli = stringdoang($_POST['poli']);
$tanggal = date("Y-m-d");

$coba = $db->query("SELECT no_urut FROM registrasi WHERE jenis_pasien = 'Rawat Jalan' AND status = 'menunggu' AND poli = '$poli' AND tanggal = '$tanggal' ORDER BY no_urut ASC LIMIT 1 ");
$dd = mysqli_fetch_array($coba);

if ($dd['no_urut'] == $no_urut) {
	echo"1";
}
else {
	echo"0";
}

?>