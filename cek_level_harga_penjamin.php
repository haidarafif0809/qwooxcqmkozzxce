<?php
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_POST['penjamin']);
$query2 = $db->query(" SELECT harga FROM penjamin WHERE nama = '$penjamin'");
$data2  = mysqli_fetch_array($query2);
echo $level_harga = $data2['harga'];


?>