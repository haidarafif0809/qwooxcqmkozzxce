<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$kode_barang = stringdoang($_POST['kode']);
$no_reg = stringdoang($_POST['no_reg']);

$foto = $db->query("SELECT foto FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND kode_barang = '$kode_barang'");
$data_foto = mysqli_fetch_array($foto);

// PERINTAH UNTUK MEMISAHKAN STRING DENGAN TANDA , (koma)
$nama_foto = $data_foto['foto'];
$pisah_nama_foto = explode(",", $nama_foto);

echo json_encode($pisah_nama_foto);

?>