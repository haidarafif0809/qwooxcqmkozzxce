<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $input_tanggal = stringdoang($_POST['input_tanggal']);


       $query =$db->prepare("UPDATE tbs_penjualan SET tanggal = ?  WHERE id = ? AND lab = 'Laboratorium'");

       $query->bind_param("si",
       $input_tanggal, $id);

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