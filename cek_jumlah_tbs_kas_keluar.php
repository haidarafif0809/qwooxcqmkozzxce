<?php 

include 'db.php';

$dari_akun = $_POST['dari_akun'];
$jumlah = $_POST['jumlah'];
$session_id = $_POST['session_id'];


$select = $db->query("SELECT SUM(jumlah) AS jumlah FROM tbs_kas_keluar WHERE session_id = '$session_id' AND dari_akun = '$dari_akun'");
$data = mysqli_fetch_array($select);

echo $jumlah_tbs = $data['jumlah'] + $jumlah;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

