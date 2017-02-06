 <?php 
 include 'db.php';
 include 'sanitasi.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_barang = stringdoang($_POST['kode_barang']);



  $select_hpp_keluar2 = $db->query("SELECT COUNT(*) FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' AND kode_barang = '$kode_barang'");
  $cek_hpp_kel2 = mysqli_fetch_array($select_hpp_keluar2);


if ($cek_hpp_kel2 == 0)
{
	echo 0;
}
else
{
	echo 1;
}




?>