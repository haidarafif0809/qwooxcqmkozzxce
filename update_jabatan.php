<?php
include 'sanitasi.php';
include 'db.php';

    $id = angkadoang($_POST['id']);
    $nama = stringdoang($_POST['nama']);
    $www = stringdoang($_POST['www']);
    $jenis_update = stringdoang($_POST['jenis_update']);

    if ($jenis_update == 'Jabatan') {
         $query = $db->prepare("UPDATE jabatan SET nama = ? 
            WHERE id = ?");

            $query->bind_param("si",
                $nama, $id);
                


            $query->execute();


                if (!$query) 
                {
                die('Query Error : '.$db->errno.
                ' - '.$db->error);
                }

    }
    elseif ($jenis_update == 'www') {
         $query1 = $db->prepare("UPDATE jabatan SET wewenang = ? 
            WHERE id = ?");

            $query1->bind_param("si",
                $www, $id);
                


            $query1->execute();


                if (!$query) 
                {
                die('Query Error : '.$db->errno.
                ' - '.$db->error);
                }
    }
    

   

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>