<?php 
include 'session_login.php';
include 'db.php';

$session_id = session_id();

 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id' AND (no_reg IS NULL OR no_reg = '') AND lab IS NULL");
 $data = mysqli_fetch_array($query);

 echo $data['total_penjualan'];
mysqli_close($db); 

  ?>


