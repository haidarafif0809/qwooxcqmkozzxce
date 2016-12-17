<?php
    // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_kode = stringdoang($_POST['input_kode']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'kode_operasi') {

       $query =$db->prepare("UPDATE operasi SET kode_operasi = ?  WHERE id_operasi = ?");

       $query->bind_param("si",
        $input_kode, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


 ?>