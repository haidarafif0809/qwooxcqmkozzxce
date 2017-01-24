<?php session_start();
include 'db.php';
include 'sanitasi.php';
include 'cache.class.php';


    // setup 'default' cache
    $c = new Cache();

     // store a string

    // generate a new cache file with the name 'newcache'
    

    $c->setCache('produk_lab');

    $c->eraseAll();



$query = $db->query("SELECT * FROM jasa_lab ");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_lab'], array(
      'kode_lab' => $data['kode_lab'],
      'nama' => $data['nama'],
      'harga_1' => $data['harga_1'],
      'harga_2' => $data['harga_2'],
      'harga_3' => $data['harga_3'],
      'harga_4' => $data['harga_4'],
      'harga_5' => $data['harga_5'],
      'harga_6' => $data['harga_6'],
      'harga_7' => $data['harga_7'],
      'persiapan' => $data['persiapan'],
      'id_jasa' => $data['id'],
      'bidang' => $data['bidang'],
      

    ));




}

$c->retrieveAll();
$retrieve = $c->retrieveAll();

foreach ($retrieve as $key) {

  echo $key['kode_lab'];echo "<br>";
  echo $key['nama'];echo "<br>";
}
   
