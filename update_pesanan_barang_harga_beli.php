<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$harga_baru = stringdoang($_POST['harga_baru']);
$harga_baru = str_replace(',','.',$harga_baru);
   if ($harga_baru == '') 
 {
   $harga_baru = 0;
 }

$harga_lama = stringdoang($_POST['harga_lama']);
$harga_lama = str_replace(',','.',$harga_lama);
   if ($harga_lama == '') 
 {
   $harga_lama = 0;
 }

$potongan = stringdoang($_POST['potongan']);
$potongan = str_replace(',','.',$potongan);
   if ($potongan == '') 
 {
   $potongan = 0;
 }

$jumlah = stringdoang($_POST['jumlah']);
$jumlah_tax = stringdoang($_POST['jumlah_tax']);
$jumlah_tax = str_replace(',','.',$jumlah_tax);
   if ($jumlah_tax == '') 
 {
   $jumlah_tax = 0;
 }
$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);


$subtotal = $jumlah * $harga_baru - $potongan;


if ($harga_lama != $harga_baru){
        $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
      }
      else{
        $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_lama' WHERE kode_barang = '$kode_barang'");
      }



$query00 = $db->query("SELECT kode_barang,no_faktur FROM tbs_pembelian WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur'];

$query = $db->prepare("UPDATE tbs_pembelian SET harga = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("sssi",
    $harga_baru, $subtotal, $jumlah_tax, $id);

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
