<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);

    $query_update_hasil =$db->prepare("UPDATE hasil_lab SET hasil_pemeriksaan = ?  WHERE id = ?");

    $query_update_hasil->bind_param("si", $input_nama, $id);

    $query_update_hasil->execute();

    if (!$query_update_hasil) 
    {
     die('Query Error : '.$db->errno.
     ' - '.$db->error);
    }
    else {

    }

 ?>