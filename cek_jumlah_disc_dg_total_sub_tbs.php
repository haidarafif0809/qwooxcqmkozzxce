<?php session_start();

include 'sanitasi.php';
include 'db.php';
	$session_id = session_id();

$querytbs = $db->query("SELECT sum(subtotal) as totale , sum(potongan) as potongane FROM tbs_penjualan WHERE session_id = '$session_id'");
$row_tbs = mysqli_num_rows($querytbs);
$idtbs = mysqli_fetch_array($querytbs);

if ($row_tbs > 0){

  echo json_encode($idtbs);
}
else {
echo 0;
}


 



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


