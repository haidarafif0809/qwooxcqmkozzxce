<?php session_start();

include 'db.php';
include 'sanitasi.php';


$kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
 $harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);
$subtotal = angkadoang($_POST['subtotal']);


$user = $_SESSION['nama'];
 $id = angkadoang($_POST['id']);


$query00 = $db->query("SELECT * FROM tbs_penjualan_radiologi WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$nomor = $data['no_faktur'];
$no_reg = $data['no_reg'];

$query = $db->prepare("UPDATE tbs_penjualan_radiologi SET jumlah_barang = ?, subtotal = ? , tax = ? WHERE id = ? ");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }
                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
