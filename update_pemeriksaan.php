<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    /*
    $input_harga_2 = stringdoang($_POST['input_harga_2']);
    $input_harga_3 = stringdoang($_POST['input_harga_3']);
    $input_harga_4 = stringdoang($_POST['input_harga_4']);
    $input_harga_5 = stringdoang($_POST['input_harga_5']);
    $input_harga_6 = stringdoang($_POST['input_harga_6']);
    $input_harga_7 = stringdoang($_POST['input_harga_7']);
    */
    $jenis_edit = stringdoang($_POST['jenis_edit']);
    

if ($jenis_edit == 'nama_pemeriksaan') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET nama_pemeriksaan = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_nama, $id);

    $input_nama = stringdoang($_POST['input_nama']);


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
    

if ($jenis_edit == 'harga_1') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_1 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_1, $id);

    $input_harga_1 = stringdoang($_POST['input_harga_1']);

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

/*    

if ($jenis_edit == 'harga_2') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_2 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_2, $id);


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
    

if ($jenis_edit == 'harga_3') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_3 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_3, $id);


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
    

if ($jenis_edit == 'harga_4') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_4 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_4, $id);


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
    

if ($jenis_edit == 'harga_5') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_5 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_5, $id);


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
    

if ($jenis_edit == 'harga_6') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_6 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_6, $id);


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
    

if ($jenis_edit == 'harga_7') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET harga_7 = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_harga_7, $id);


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
    
*/


if ($jenis_edit == 'no_urut') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET no_urut = ?  WHERE id = ?");

       $query->bind_param("si",
        $no_urut, $id);

    $no_urut = stringdoang($_POST['input_urutan']);

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


if ($jenis_edit == 'kontras') {

       $query =$db->prepare("UPDATE pemeriksaan_radiologi SET kontras = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_kontras, $id);

    $select_kontras = stringdoang($_POST['select_kontras']);

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

  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>