<?php 
include 'db.php';
include 'sanitasi.php';

$rm = stringdoang($_POST['rm']);
$reg = stringdoang($_POST['reg']);

$query = $db->query("SELECT no_periksa FROM pemeriksaan_lab_inap WHERE no_rm = '$rm' AND no_reg = '$reg' ORDER BY no_periksa DESC");
$jumlah = mysqli_num_rows($query);
$hasil = mysqli_fetch_array($query);
$data_periksa = $hasil['no_periksa'];
if ($data_periksa == '') 
{
	echo $hasil_akhir = 1;
	
}
else
{
	echo $hasil_akhir = $hasil + 1;
}


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>