<?php 
include 'db.php';
include 'sanitasi.php';

$pemeriksa_keberapa = stringdoang($_POST['pemeriksa_keberapa']);
$nama = stringdoang($_POST['nama_pasien']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$waktu =  date('Y-m-d H:i:s');

$insert = $db->query("INSERT INTO pemeriksaan_lab_inap 
	(no_rm,no_reg,no_periksa,waktu,status,nama_pasien) VALUES ('$no_rm','$no_reg','$pemeriksa_keberapa','$waktu','0','$nama')");


        //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);
        
 ?>