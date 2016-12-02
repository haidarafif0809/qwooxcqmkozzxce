<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id']);


$query = $db->query("SELECT * FROM penjamin WHERE id = '$id' ");
$data = mysqli_fetch_array($query);
echo $layanan = $data['cakupan_layanan'];
?>

