<?php 

include 'db.php';

$no_reg = $_POST['no_reg'];

$query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

