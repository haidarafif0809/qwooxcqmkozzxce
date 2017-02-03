<?php 
include 'db.php';
include 'sanitasi.php';

echo $no_faktur = stringdoang($_POST['no_faktur']);
 $dokter = stringdoang($_POST['dokter']);
 $analis = stringdoang($_POST['analis']);

$tanggal = date('Y-m-d');
$jam = date('H:m:s');

$update = $db->query("UPDATE hasil_lab SET dokter = '$dokter', petugas_analis = '$analis', status = 'Selesai', tanggal = '$tanggal', jam = '$jam' WHERE no_faktur = '$no_faktur'");

	  if ($db->query($update) === TRUE)
      {

      } 
      else 
      { 
     
      }



?>