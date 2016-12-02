<?php
include 'db.php';
include 'sanitasi.php';

$tanggal_lahir = stringdoang($_POST['tanggal_lahir']);
$tanggal_lahir = tanggal_mysql($tanggal_lahir);
$query = $db->query("SELECT TIMESTAMPDIFF(MONTH,'$tanggal_lahir', CURDATE()) AS umur ");
$data = mysqli_fetch_array($query);
$data['umur'];
$umur = $data['umur'] / 12;

if ($umur < 1){

echo $umur = $data['umur']." bulan";

}
else {

$query = $db->query("SELECT TIMESTAMPDIFF(YEAR,'$tanggal_lahir', CURDATE()) AS umur ");
$data = mysqli_fetch_array($query);
echo $data['umur']." tahun";
}


?>