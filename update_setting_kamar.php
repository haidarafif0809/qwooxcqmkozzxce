update_setting_registrasi<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $select_tampil = stringdoang($_POST['select_tampil']);
    $jenis_select = stringdoang($_POST['jenis_select']);


		$query =$db->prepare("UPDATE setting_kamar SET proses_kamar = ?  WHERE id = ?");
		
		$query->bind_param("si",
        $select_tampil, $id);


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