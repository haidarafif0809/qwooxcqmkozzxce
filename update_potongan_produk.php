<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $potongan = angkadoang($_POST['input_potongan']);
    $tax = angkadoang($_POST['hasil_tax_baru']);
    $subtotal = angkadoang($_POST['subtotal_tbs']);


       $query =$db->prepare("UPDATE tbs_penjualan SET potongan = ? , tax = ?, subtotal = ? WHERE id = ?");

       $query->bind_param("iiii",
       $potongan,$tax,$subtotal, $id);

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