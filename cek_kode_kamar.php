<?php 
include 'db.php';
include 'sanitasi.php';
$nama = stringdoang($_POST['nama']);

$select = $db->query("SELECT nama_kamar FROM bed WHERE nama_kamar = '$nama'");
$jumlah = mysqli_num_rows($select);


if ($jumlah > 0){

  echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
        
        

 ?>