<?php 


header('Content-Type: application/json');

include 'db.php';

$query_petugas = $db->query("SELECT id,nama,tipe  FROM user  ");
$result = array();

$query_penetapan_petugas = $db->query("SELECT * FROM penetapan_petugas  ");
$data_penetapan_petugas = mysqli_fetch_array($query_penetapan_petugas);

while ($data_petugas = mysqli_fetch_array($query_petugas)) {

	if ($data_petugas['nama'] == $data_penetapan_petugas['nama_dokter']) {
		array_push($result, ['id' => $data_petugas['id'],
							'nama' => $data_petugas['nama'],
							'tipe' => $data_petugas['tipe'],
							'penetapan_petugas' => 'dokter',
		]); 		
	}

	elseif ($data_petugas['nama'] == $data_penetapan_petugas['nama_paramedik']) {
		array_push($result, ['id' => $data_petugas['id'],
							'nama' => $data_petugas['nama'],
							'tipe' => $data_petugas['tipe'],
							'penetapan_petugas' => 'paramedik',
		]); 		
	}   
	elseif ($data_petugas['nama'] == $data_penetapan_petugas['nama_farmasi']) {
		array_push($result, ['id' => $data_petugas['id'],
							'nama' => $data_petugas['nama'],
							'tipe' => $data_petugas['tipe'],
							'penetapan_petugas' => 'farmasi',
		]); 		
	} 
	else {

		array_push($result, ['id' => $data_petugas['id'],
							'nama' => $data_petugas['nama'],
							'tipe' => $data_petugas['tipe'],
							'penetapan_petugas' => '',
		]); 	
	}     	
	

       }       
echo json_encode(array('result'=>$result));
 

       
 ?>