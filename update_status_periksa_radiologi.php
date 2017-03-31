<?php 
    include 'sanitasi.php';
    include 'db.php';

    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $no_reg = stringdoang($_POST['no_reg']);       
    $select_status = stringdoang($_POST['select_status']);
       
       $query =$db->prepare("UPDATE tbs_penjualan_radiologi SET status_periksa = ?  WHERE id = ? AND no_reg = ?");

       $query->bind_param("sis",
       $select_status, $id, $no_reg);


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