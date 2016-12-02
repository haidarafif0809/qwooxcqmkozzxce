<?php 
include 'db.php';
include 'sanitasi.php';

echo $no_reg = stringdoang($_POST['no_reg']);
echo $keterangan = stringdoang($_POST['keterangan']);

$select = $db->query("SELECT no_faktur FROM penjualan WHERE no_reg = '$no_reg'");
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
$delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg'");

$query = $db->query("UPDATE registrasi SET status = 'Batal Rawat Inap', keterangan = '$keterangan' WHERE no_reg = '$no_reg' AND jenis_pasien = 'Rawat Inap' ");  

$select_kamr = $db->query("SELECT bed,group_bed FROM registrasi WHERE no_reg  = '$no_reg' ");
$kk = mysqli_fetch_array($select_kamr);


$query_bed = "UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '$kk[bed]' AND group_bed = '$kk[group_bed]' ";
if ($db->query($query_bed) === TRUE) {

} 
else 
	{
    echo "Error: " . $query_bed . "<br>" . $db->error;
     }

$ss = "DELETE FROM tbs_penjualan WHERE kode_barang = '$kk[bed]' AND no_reg = '$no_reg' ";
if ($db->query($ss) === TRUE) {
    
} 
else {
    echo "Error: " . $ss . "<br>" . $db->error;
     }

$query_del = "DELETE FROM rekam_medik_inap WHERE no_reg = '$no_reg'";
if ($db->query($query_del) === TRUE) {
    
} 
else {
    echo "Error: " . $query_del . "<br>" . $db->error;
     }


 ?>