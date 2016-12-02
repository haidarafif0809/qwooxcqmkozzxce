<?php 

include 'db.php';

$nama = $_POST['nama'];
$no_reg = $_POST['no_reg'];

$query = $db->query("SELECT kode_barang FROM barang WHERE nama_barang = '$nama'");
$data = mysqli_fetch_array($query);

$qq = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' AND kode_barang = '$data[kode_barang]' ");
$jumlah = mysqli_num_rows($qq);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

