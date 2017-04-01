<?php 
include 'db.php';
include 'sanitasi.php';
$nama = stringdoang($_POST['nama']);
$ruangan = stringdoang($_POST['ruangan']);

$select = $db->query("SELECT b.nama_kamar,b.ruangan FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE b.nama_kamar = '$nama' AND b.ruangan = '$ruangan'");
$jumlah = mysqli_num_rows($select);

$select1 = $db->query("SELECT kode_barang FROM barang WHERE kode_barang = '$nama'");
$jumlah1 = mysqli_num_rows($select1);

if ($jumlah > 0){

  echo 1;
}
elseif($jumlah1 > 0) {
	echo 2;
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
        
        

 ?>