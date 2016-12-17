<?php 
include 'sanitasi.php';
include 'db.php';

$input_kode = stringdoang($_POST['input_kode']);


$query = $db->query("SELECT * FROM operasi WHERE kode_operasi = '$input_kode'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

