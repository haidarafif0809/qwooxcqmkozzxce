<?php 

include 'db.php';
include 'sanitasi.php';

    $no_rm = stringdoang($_GET['no_rm']);
    $session_id = session_id();
 
    //ambil data barang

$result = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_rm' AND status != 'Sudah Pulang' ");
$row = mysqli_fetch_array($result);
   
$cek = $db->query("SELECT harga FROM penjamin WHERE nama = '$row[penjamin]'");
$data = mysqli_fetch_array($cek);
$harga_level = $data['harga'];

$query = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_rm'");
$data2 = mysqli_fetch_array($query);

$tax = $data2['tax'];
$diskon = $data2['potongan'];

$query76 = $db->query("SELECT SUM(subtotal) AS total FROM tbs_penjualan WHERE no_reg = '$no_rm' ");
$data4 = mysqli_fetch_array($query76);
$subtotal = $data4['total'];

$total = $subtotal - $diskon + $tax;


$row['provinsi'] = $harga_level;
$row['keterangan'] = $subtotal;
$row['petugas'] = $total;



    echo json_encode($row);
    exit;

     ?>