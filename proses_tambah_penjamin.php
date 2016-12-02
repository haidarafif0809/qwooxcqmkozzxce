<?php 
    include 'db.php';
    include_once 'sanitasi.php';


    $perintah = $db->prepare("INSERT INTO penjamin (nama,alamat,no_telp,harga,cakupan_layanan,jatuh_tempo) VALUES (?,?,?,?,?,?) ");

    $perintah->bind_param("ssisss",$nama, $alamat, $no_telp, $harga, $cakupan_layanan, $jatuh_tempo);
        

        $nama = stringdoang($_POST['nama']);
        $alamat = stringdoang($_POST['alamat']);
        $no_telp = angkadoang($_POST['no_telp']);
        $harga = stringdoang($_POST['level_harga']);
        $cakupan_layanan = $_POST['layanan'];
        $jatuh_tempo = stringdoang($_POST['jatuh_tempo']);
  
    $perintah->execute();

    if (!$perintah) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {  
      echo'<META HTTP-EQUIV="Refresh" Content="0; URL=penjamin.php">';
    }




//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>
