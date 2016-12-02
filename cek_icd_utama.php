<?php 

include 'db.php';
include 'sanitasi.php';


$diagnosa_utama = stringdoang($_GET['term']);

$query = $db->query("SELECT * FROM icd WHERE Deskripsi_ina LIKE '%".$diagnosa_utama."%' ORDER BY Deskripsi_ina  ASC ");
while($a = mysqli_fetch_array($query)) 
{
	
	$data[] = ''.$a['ICD'].' - '.$a['Deskripsi_ina'].'' ;

}


    echo json_encode($data);



?>
