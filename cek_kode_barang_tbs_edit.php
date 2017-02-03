<?php session_start();

include 'db.php';

$kode_barang = $_POST['kode_barang'];
$no_reg = $_POST['no_reg'];

$query = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_reg = '$no_reg' ");
$jumlah = mysqli_num_rows($query);

if ($jumlah > 0){

  echo 1;
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

