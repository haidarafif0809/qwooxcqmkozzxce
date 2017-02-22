<?php 
include 'db.php';
include_once 'sanitasi.php';

$select_reg = $db->query("SELECT * FROM reg  ");
while ($dp = mysqli_fetch_array($select_reg)) {

	$select = $db->query("SELECT * FROM registrasi WHERE no_reg = '$dp[no_reg]'");
	$ambil = mysqli_fetch_array($select);

	$rekam_medik = "INSERT INTO rekam_medik(alergi, no_kk, nama_kk, no_reg, no_rm, nama, alamat, umur, jenis_kelamin, sistole_distole, suhu, berat_badan, tinggi_badan, nadi, respiratory, poli, tanggal_periksa, jam, dokter, kondisi, rujukan) VALUES ('$ambil[alergi]', '$ambil[no_kk]', '$ambil[nama_kk]', '$ambil[no_reg]', '$ambil[no_rm]', '$ambil[nama_pasien]', '$ambil[alamat_pasien]', '$ambil[umur_pasien]', '$ambil[jenis_kelamin]', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', '$ambil[poli]', '$ambil[tanggal] $ambil[jam]', '$ambil[jam]', '$ambil[dokter]', '$ambil[kondisi]', '$ambil[rujukan]')";


	if ($db->query($rekam_medik) === TRUE) {

	} 
    else{
	echo "Error: " . $rekam_medik . "<br>" . $db->error;
	}
}

	echo "SUKSES";
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);

?>