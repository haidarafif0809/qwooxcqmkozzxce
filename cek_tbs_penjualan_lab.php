<?php 
include 'db.php';
include 'sanitasi.php';


$no_reg = stringdoang($_POST['no_reg']);
$kode_barang = stringdoang($_POST['kode_barang']);
$session_id = stringdoang($_POST['session_id']);

$query = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND no_reg = '$no_reg'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

