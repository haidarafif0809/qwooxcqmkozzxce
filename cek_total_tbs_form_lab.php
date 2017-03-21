<?php 
include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$no_reg = stringdoang($_GET['no_reg']);
$pemeriksa_keberapa = stringdoang($_GET['pemeriksa_keberapa']);


 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$pemeriksa_keberapa' AND lab = 'Laboratorium' ");
 $data = mysqli_fetch_array($query);

 echo $data['total_penjualan'];
mysqli_close($db); 

  ?>


