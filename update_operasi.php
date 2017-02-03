<?php
    // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'nama_operasi') {

       $query =$db->prepare("UPDATE operasi SET nama_operasi = ?  WHERE id_operasi = ?");

       $query->bind_param("si",
        $input_nama, $id);


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