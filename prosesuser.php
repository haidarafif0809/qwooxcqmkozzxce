<?php 
    include 'db.php';
    include_once 'sanitasi.php';


    $perintah = $db->prepare("INSERT INTO user (username,password,nama,alamat,jabatan,otoritas,status,status_sales,tipe) VALUES (?,?,?,?,?,?,?,?,?)");

    $perintah->bind_param("sssssssss",
        $username, $password, $nama, $alamat, $jabatan, $otoritas, $status, $status_sales,$tipe);
        
        $username = stringdoang($_POST['username']);
        $password = enkripsi($_POST['password']);
        $nama = stringdoang($_POST['nama']);
        $alamat = stringdoang($_POST['alamat']);
        $jabatan= stringdoang($_POST['jabatan']);
        $otoritas = stringdoang($_POST['otoritas']);
        $status = stringdoang($_POST['status']);
        $status_sales = stringdoang($_POST['status_sales']);
        $tipe = stringdoang($_POST['tipe']);
    
    $perintah->execute();

    if (!$perintah) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>
