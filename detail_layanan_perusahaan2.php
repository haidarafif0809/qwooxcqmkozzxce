<?php 
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_POST['penjamin']);


$query = $db->query("SELECT * FROM penjamin WHERE nama = '$penjamin' ");
$data = mysqli_fetch_array($query);
$layanan = $data['cakupan_layanan'];
?>

<h3><?php echo $layanan;?></h3>