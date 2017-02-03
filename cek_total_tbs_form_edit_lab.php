<?php 
include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$no_faktur = stringdoang($_POST['no_faktur']);

 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");
 $data = mysqli_fetch_array($query);

 echo $data['total_penjualan'];
mysqli_close($db); 

  ?>


