<?php 
include 'sanitasi.php';
include 'db.php';

$kode = stringdoang($_POST['kode']);


$query = $db->query("SELECT * FROM operasi WHERE kode_operasi = '$kode'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

