<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $input_dosis = stringdoang($_POST['input_dosis']);


       $query =$db->prepare("UPDATE tbs_penjualan SET dosis = ?  WHERE id = ?");

       $query->bind_param("si",
       $input_dosis, $id);

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