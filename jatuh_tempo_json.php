<?php
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_GET['penjamin']);


$cek = $db->query("SELECT jatuh_tempo FROM penjamin WHERE nama = '$penjamin'");
$data = mysqli_fetch_array($cek);
$hari = $data['jatuh_tempo'];

$todayDate = date("Y-m-d");// current date

$now = strtotime(date("Y-m-d"));
//Add one day to today
$date = date('Y-m-d', strtotime('+ '.$hari.' day', $now));

if ($date == '1970-01-01') {
	$date = null;
}
else{
	$date = $date;
}
$row['harga'] = $date;
echo json_encode($row);
    exit;

?>