<?php 
include 'db.php';
include 'sanitasi.php';

$pemeriksaan_keberapa = stringdoang($_POST['pemeriksaan_keberapa']);
$nama = stringdoang($_POST['nama_pasien']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$waktu =  date('Y-m-d H:i:s');

$query_insert_data_periksa_inap = "INSERT INTO pemeriksaan_lab_inap (no_rm,no_reg,no_periksa,waktu,status,nama_pasien) VALUES 
('$no_rm','$no_reg','$pemeriksaan_keberapa','$waktu','0','$nama')";


if ($db->query($query_insert_data_periksa_inap) === TRUE){
	echo "1";

}
else{
	echo "Error: " . $query_insert_data_periksa_inap . "<br>" . $db->error;
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);      
?>