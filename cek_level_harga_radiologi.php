<?php 

include 'db.php';
include 'sanitasi.php';


$level_harga =  stringdoang($_POST['level_harga']);
$jumlah_barang =  stringdoang($_POST['jumlah_barang']);
$id_produk =  stringdoang($_POST['id_produk']);




$query = $db->query("SELECT harga_1,harga_2,harga_3,harga_4,harga_5,harga_6,harga_7  FROM pemeriksaan_radiologi WHERE id = '$id_produk'");
$data_harga = mysqli_fetch_array($query);

if ($level_harga == 'harga_1') {
	 $harga = $data_harga['harga_1'];
}
elseif ($level_harga == 'harga_2') {
	 $harga = $data_harga['harga_2'];
}
elseif ($level_harga == 'harga_3') {
	 $harga = $data_harga['harga_3'];
}
elseif ($level_harga == 'harga_4') {
	 $harga = $data_harga['harga_4'];
}
elseif ($level_harga == 'harga_5') {
	 $harga = $data_harga['harga_5'];
}
elseif ($level_harga == 'harga_6') {
	 $harga = $data_harga['harga_6'];
}
elseif ($level_harga == 'harga_7') {
	 $harga = $data_harga['harga_7'];
}


echo$tampil = $harga * $jumlah_barang;



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>