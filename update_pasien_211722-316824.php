<?php include 'db.php';

$pasien = $db_pasien->query("SELECT kode_pelanggan,tgl_lahir_pasien FROM pasien_aris WHERE id_pasien >='211722' AND id_pasien<='316824'");
while($data = mysqli_fetch_array($pasien)){

	$update = $db_pasien->query("UPDATE pelanggan SET kode_pelanggan = '$data[kode_pelanggan]' , tgl_lahir = '$data[tgl_lahir_pasien]' WHERE id >='211722' AND id<='316824'");
	
}

?>
