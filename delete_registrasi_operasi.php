<?php 

include 'db.php';

$id = $_POST['id'];
$or = $_POST['or'];
$sub = $_POST['sub'];

$taked = $db->query("SELECT id_tbs_operasi FROM tbs_detail_operasi WHERE id_operasi = '$or' AND id_sub_operasi = '$sub'");
$out = mysqli_fetch_array($taked);
if ($id == $out['id_tbs_operasi'])
{
$query_delete_detailnya = $db->query("DELETE FROM tbs_detail_operasi WHERE id_tbs_operasi = '$id'");
}

$query = $db->query("DELETE FROM tbs_operasi WHERE id = '$id'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);  
?>