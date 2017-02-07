<?php 


include 'db.php';

$query = $db->query("SELECT kode_barang, nama_barang, harga_jual, harga_jual2, harga_jual3, harga_jual4, harga_jual5, harga_jual6, harga_jual7, satuan, kategori, status, limit_stok, berkaitan_dgn_stok, tipe_barang, id FROM barang ");


while ($data = $query->fetch_array()) {
	# code...

	$arr[]=array(
		'id' => $data['id'],
		'kode_barang' => $data['kode_barang'],
		'nama_barang' => $data['nama_barang'],
		'harga_jual' => $data['harga_jual'],
		'harga_jual2' => $data['harga_jual2'],
		'harga_jual3' => $data['harga_jual3'],
		'harga_jual4' => $data['harga_jual4'],
		'harga_jual5' => $data['harga_jual5'],
		'harga_jual6' => $data['harga_jual6'],
		'harga_jual7' => $data['harga_jual7'],
		'satuan' => $data['satuan'],
		'kategori' => $data['kategori'],
		'status' => $data['status'],
		'limit_stok' => $data['limit_stok'],
		'berkaitan_dgn_stok' => $data['berkaitan_dgn_stok'],
		'tipe_barang' => $data['tipe_barang']


		);
}

echo json_encode(array('barang' => $arr));