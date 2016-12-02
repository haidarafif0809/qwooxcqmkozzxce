<?php 
include 'db.php';
include 'sanitasi.php';
$kode = stringdoang($_POST['kode']);

$select = $db->query("SELECT kode_gudang FROM gudang WHERE kode_gudang = '$kode'");
$jumlah = mysqli_num_rows($select);


if ($jumlah > 0){

  echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
        
        

 ?>