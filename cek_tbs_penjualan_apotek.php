<?php 

include 'db.php';

$kode_barang = $_POST['kode_barang'];
$session_id = $_POST['session_id'];

$query = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND (no_reg = '' OR no_reg IS NULL) ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

