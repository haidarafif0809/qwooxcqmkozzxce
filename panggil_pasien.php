
<?php 
include 'db.php';
include_once'sanitasi.php';

$id = angkadoang($_POST['id']);
$status = stringdoang($_POST['status']);


$tanggal = date("Y-m-d");

if ($status == 'di panggil')
{

$query = $db->query("UPDATE registrasi SET status = '$status' WHERE id = '$id'");

}
elseif ($status == 'Proses') {
  $query = $db->query("UPDATE registrasi SET status = '$status' WHERE id = '$id'");

}



?>

