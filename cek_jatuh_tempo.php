<?php
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_POST['penjamin']);


$cek = $db->query("SELECT jatuh_tempo FROM penjamin WHERE nama = '$penjamin'");
$data = mysqli_fetch_array($cek);
$hari = $data['jatuh_tempo'];

$todayDate = date("Y-m-d");// current date

$now = strtotime(date("Y-m-d"));
//Add one day to today
echo $date = date('Y-m-d', strtotime('+ '.$hari.' day', $now));

?>