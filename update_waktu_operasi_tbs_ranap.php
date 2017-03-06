<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $input_waktu = stringdoang($_POST['input_waktu']);


       $query =$db->prepare("UPDATE tbs_operasi SET waktu = ?  WHERE id = ?");

       $query->bind_param("si",
       $input_waktu, $id);

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