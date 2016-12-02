<?php 

include 'db.php';

$keakun = $_POST['keakun'];
$dariakun = $_POST['dariakun'];
$session_id = $_POST['session_id'];

$select = $db->query("SELECT * FROM tbs_kas_keluar WHERE session_id = '$session_id' AND ke_akun = '$keakun' AND dari_akun = '$dariakun'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ya";
}
else{

}

 ?>