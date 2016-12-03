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


$query00 = $db->query("SELECT * FROM tbs_penjualan WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$nomor = $data['no_faktur'];
$no_reg = $data['no_reg'];

$query = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = ?, subtotal = ? , tax = ? WHERE id = ? ");


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
    $query9 = $db->query("SELECT * FROM tbs_fee_produk WHERE kode_produk = '$kode_barang' AND no_reg = '$no_reg' AND no_rm = '$kode_pelanggan' ");
    while($cek9 = mysqli_fetch_array($query9))
    {

$select_fee = $db->query("SELECT jumlah_uang,jumlah_prosentase FROM fee_produk WHERE nama_petugas = '$cek9[nama_petugas]' AND kode_produk = '$cek9[kode_produk]' ");


$ff = mysqli_fetch_array($select_fee);

    $nominal = $ff['jumlah_uang'];
    $prosentase = $ff['jumlah_prosentase'];
    $nm_pet = $cek9['nama_petugas'];



        if ($prosentase != 0)

            {
            $fee_prosentase_produk = $prosentase * $subtotal / 100;
            $query1 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_prosentase_produk' WHERE nama_petugas = '$nm_pet' AND kode_produk = '$kode_barang' AND no_reg = '$no_reg' AND no_rm = '$kode_pelanggan'  ");


            }

   elseif ($nominal != 0) 

            {
            $fee_nominal_produk = $nominal * $jumlah_baru;
            $query01 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$nm_pet' AND kode_produk = '$kode_barang' AND no_reg = '$no_reg' AND no_rm = '$kode_pelanggan' ");

            }
  }
                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
