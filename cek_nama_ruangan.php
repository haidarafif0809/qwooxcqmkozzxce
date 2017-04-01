<?php

include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama_ruangan']);

$query = $db->query("SELECT nama_ruangan FROM ruangan WHERE nama_ruangan = '$nama' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

