<?php 


header('Content-Type: application/json');

include 'db.php';

$query_suplier = $db->query("SELECT id,nama  FROM penjamin ");
$result = array();
while ($data_suplier = mysqli_fetch_array($query_suplier)) {
       	
	array_push($result, ['id' => $data_suplier['id'],
						'nama' => $data_suplier['nama']
						]);

       }       
echo json_encode(array('result'=>$result));
 

       
 ?>