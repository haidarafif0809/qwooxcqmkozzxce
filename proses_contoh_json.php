<?php 


include 'db.php';

$query = $db->query("SELECT * FROM barang ");


while ($data = $query->fetch_array()) {
	# code...

	$arr[]=array(
		'id' => $data['id'],
		'kode_barang' => $data['kode_barang'],
		'nama_barang' => $data['nama_barang']
		);
}

echo json_encode(array('barang' => $arr));