<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);



       $query =$db->prepare("UPDATE hasil_lab SET status_abnormal = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_nama, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}




 ?>