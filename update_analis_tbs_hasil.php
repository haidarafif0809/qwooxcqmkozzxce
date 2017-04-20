<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);



    $query =$db->prepare("UPDATE tbs_hasil_lab SET analis = ? WHERE id = ?");

    $query->bind_param("si",
    $input_nama, $id);

    $query->execute();

        if (!$query){
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
        else{
        }

  $query_ambil_nama = $db->query("SELECT nama FROM user WHERE id = '$input_nama'");
    $data_nama = mysqli_fetch_array($query_ambil_nama);
   echo $nama = $data_nama['nama'];
?>