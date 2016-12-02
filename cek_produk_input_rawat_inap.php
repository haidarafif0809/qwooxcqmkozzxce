<?php 
include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_POST['kode_barang']);
$no_faktur = stringdoang($_POST['no_faktur']);

$waktu_sekerang = date('Y-m-d H:i:s');

$select = $db->query("SELECT kode_barang,no_faktur,jam,tanggal FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' ORDER BY id DESC LIMIT 1");

$my = mysqli_num_rows($select);
$my2 = mysqli_fetch_array($select);

$jam = $my2['jam'];
$tanggal = $my2['tanggal'];
$waktu = $tanggal." ".$jam;

$query65 = $db->query("SELECT HOUR(TIMEDIFF('$waktu_sekerang' , '$waktu')) AS waktu_selisih ");
$my22 = mysqli_fetch_array($query65);
$waktu_selisih = $my22['waktu_selisih'];


if ($waktu_selisih < 1 AND $my > 0)
{
	echo "ya";
}
else
	{
	echo "tidak";
	}


 ?>