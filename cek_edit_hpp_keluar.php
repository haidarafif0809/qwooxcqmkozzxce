 <?php 
 include 'db.php';
 include 'sanitasi.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);


  $select_hpp_keluar2 = $db->query("SELECT COUNT(*) FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' AND kode_barang = '$kode_barang'");
  $cek_hpp_kel2 = mysqli_fetch_array($select_hpp_keluar2);



  $select_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS sum_hpp FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' AND kode_barang = '$kode_barang'");
  $cek_hpp_kel = mysqli_fetch_array($select_hpp_keluar);
	$sum_jumlah_hpp = $cek_hpp_kel['sum_hpp'];

if ($jumlah_baru < $sum_jumlah_hpp AND $cek_hpp_kel2 > 0)
{
	echo 1;
}
else
{
	echo 0;
}




?>