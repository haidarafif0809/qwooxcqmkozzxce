<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);

// pengubahan data dari form penjualan ketika ada pengeditan (mengubah koma menjadi titik agar diterima di MYSQL )
$jumlah_baru = stringdoang($_POST['jumlah_baru']);
 $jumlah_baru = str_replace(',','.',$jumlah_baru);
   if ($jumlah_baru == '') 
 {
   $jumlah_baru = 0;
 }

$jumlah_lama = stringdoang($_POST['jumlah_lama']);
 $jumlah_lama = str_replace(',','.',$jumlah_lama);
  if ($jumlah_lama == '') 
 {
   $jumlah_lama = 0;
 }

$potongan = stringdoang($_POST['potongan']);
 $potongan = str_replace(',','.',$potongan);
   if ($potongan == '') 
 {
   $potongan = 0;
 }

$harga = stringdoang($_POST['harga']);
 $harga = str_replace(',','.',$harga);
  if ($harga == '') 
 {
   $harga = 0;
 }

$jumlah_tax = stringdoang($_POST['jumlah_tax']);
 $jumlah_tax = str_replace(',','.',$jumlah_tax);
   if ($jumlah_tax == '') 
 {
   $jumlah_tax = 0;
 }


// pengubahan data dari form penjualan ketika ada pengeditan (mengubah koma menjadi titik agar diterima di MYSQL )



$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);


$subtotal = $harga * $jumlah_baru - $potongan;

$query00 = $db->query("SELECT kode_barang,no_faktur FROM tbs_pembelian WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur'];

$query = $db->prepare("UPDATE tbs_pembelian SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("sssi",
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
echo "berhasil";


                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
