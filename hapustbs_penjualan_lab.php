<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET

$id = angkadoang($_POST['id']);
$kode_barang = stringdoang($_POST['kode_barang']);
$no_reg = stringdoang($_POST['no_reg']);
$no_faktur = stringdoang($_POST['no_faktur']);
$session_id = session_id();

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan WHERE id = '$id'");

$query2 = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_barang' AND no_faktur = '$no_faktur' ");

//jika $query benar maka akan menuju file formpenjualan.php , jika salah maka failed
if ($query == TRUE)
{
echo "sukses";
}
else
{
	
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
