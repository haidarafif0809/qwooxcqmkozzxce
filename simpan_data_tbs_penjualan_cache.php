<?php 
include 'db.php';
include 'cache.class.php';
include 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);

  $c = new Cache();
  $c->setCache('detail_penjualan');

  $query = $db->query("SELECT tp.id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,potongan,s.nama AS satuan,tax FROM tbs_penjualan tp  INNER JOIN satuan s ON tp.satuan = s.id WHERE no_reg = '$no_reg'");
  $data_detail = array();

  while ($data = $query->fetch_array()) {

  	  array_push($data_detail, ['kode_barang' => $data['kode_barang'],
              'nama_barang' => $data['nama_barang'],
              'satuan'  => $data['satuan'],
			'jumlah_barang' => $data['jumlah_barang'],
			'harga'=> $data['harga'],
			'subtotal'=> $data['subtotal'],
			'potongan'=> $data['potongan'],
			'pajak' => $data['tax']]);
  }

   $c->store($no_reg, $data_detail);

 ?>