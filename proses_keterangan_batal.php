<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['reg']);
$keterangan = stringdoang($_POST['keterangan']);

/*$select = $db->query("SELECT no_faktur FROM penjualan WHERE no_reg = '$no_reg'");
$taked = mysqli_num_rows($select);
$out = mysqli_fetch_array($select);

if ($taked > 0)
{
  $delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$out[no_faktur]'");
  $delete_hpp_keluar = $db->query("DELETE FROM hpp_keluar WHERE no_faktur = '$out[no_faktur]'");
}
else
{

}

$delete_penjualan = $db->query("DELETE FROM penjualan WHERE no_reg = '$no_reg'");
$delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg'");*/


$query = $db->query("UPDATE registrasi SET status = 'Batal Rawat', keterangan = '$keterangan' WHERE no_reg = '$no_reg' AND jenis_pasien = 'Rawat Jalan' ");  

$query_del = "DELETE FROM rekam_medik WHERE no_reg = '$no_reg'";
if ($db->query($query_del) === TRUE) {

} 
else {
    echo "Error: " . $query_del . "<br>" . $db->error;
     }
     


 ?>