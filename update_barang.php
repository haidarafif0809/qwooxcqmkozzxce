<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_beli = angkadoang($_POST['input_beli']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'harga_beli') {

       $query =$db->prepare("UPDATE barang SET harga_beli = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_beli, $id);


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

//first update harga jual 1
 $id = angkadoang($_POST['id']);
    $input_jual = angkadoang($_POST['input_jual']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'harga_jual') {

       $query =$db->prepare("UPDATE barang SET harga_jual = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 1

//first update harga jual 2
 $id = angkadoang($_POST['id']);
    $input_jual_2 = angkadoang($_POST['input_jual_2']);
    $jenis_edit_2 = stringdoang($_POST['jenis_edit_2']);

if ($jenis_edit_2 == 'harga_jual_2') {

       $query =$db->prepare("UPDATE barang SET harga_jual2 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_2, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 2

//first update harga jual 3
 $id = angkadoang($_POST['id']);
    $input_jual_3 = angkadoang($_POST['input_jual_3']);
    $jenis_edit_3 = stringdoang($_POST['jenis_edit_3']);

if ($jenis_edit_3 == 'harga_jual_3') {

       $query =$db->prepare("UPDATE barang SET harga_jual3 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_3, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 3

//first update harga jual 4
$id = angkadoang($_POST['id']);
    $input_jual_4 = angkadoang($_POST['input_jual_4']);
    $jenis_edit_4 = stringdoang($_POST['jenis_edit_4']);

if ($jenis_edit_4 == 'harga_jual_4') {

       $query =$db->prepare("UPDATE barang SET harga_jual4 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_4, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 4

//first update harga jual 5
$id = angkadoang($_POST['id']);
    $input_jual_5 = angkadoang($_POST['input_jual_5']);
    $jenis_edit_5 = stringdoang($_POST['jenis_edit_5']);

if ($jenis_edit_5 == 'harga_jual_5') {

       $query =$db->prepare("UPDATE barang SET harga_jual5 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_5, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 5

//first update harga jual 6
$id = angkadoang($_POST['id']);
    $input_jual_6 = angkadoang($_POST['input_jual_6']);
    $jenis_edit_6 = stringdoang($_POST['jenis_edit_6']);

if ($jenis_edit_6 == 'harga_jual_6') {

       $query =$db->prepare("UPDATE barang SET harga_jual6 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_6, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 6

//first update harga jual 7
$id = angkadoang($_POST['id']);
    $input_jual_7 = angkadoang($_POST['input_jual_7']);
    $jenis_edit_7 = stringdoang($_POST['jenis_edit_7']);

if ($jenis_edit_7 == 'harga_jual_7') {

       $query =$db->prepare("UPDATE barang SET harga_jual7 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_7, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update harga jual 7

//update kategori
    $id = angkadoang($_POST['id']);
    $select_kategori = stringdoang($_POST['select_kategori']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'kategori') {

       $query =$db->prepare("UPDATE barang SET kategori = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_kategori, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update kategori

//update berkaitan dg stok
    $id = angkadoang($_POST['id']);
    $select_berstok = stringdoang($_POST['select_berstok']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'berkaitan_dgn_stok') {

       $query =$db->prepare("UPDATE barang SET berkaitan_dgn_stok = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_berstok, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update berkaitan dg stok

//update satuan
    $id = angkadoang($_POST['id']);
    $select_satuan = stringdoang($_POST['select_satuan']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'satuan') {

       $query =$db->prepare("UPDATE barang SET satuan = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_satuan, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}//end update satuan
        
      
//update status
    $id = angkadoang($_POST['id']);
    $select_status = stringdoang($_POST['select_status']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'status') {

       $query =$db->prepare("UPDATE barang SET status = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_status, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  //end update status
       
   //update suplier     
    $id = angkadoang($_POST['id']);
    $select_suplier = stringdoang($_POST['select_suplier']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'suplier') {

       $query =$db->prepare("UPDATE barang SET suplier = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_suplier, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  //end update suplier

//update limit stok
    $id = angkadoang($_POST['id']);
    $input_limit = angkadoang($_POST['input_limit']);
    $jenis_limit = stringdoang($_POST['jenis_limit']);


    if ($jenis_limit == 'limit_stok') {

       $query =$db->prepare("UPDATE barang SET limit_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_limit, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  //end update limit stok


    $id = angkadoang($_POST['id']);
    $input_over = angkadoang($_POST['input_over']);
    $jenis_over = stringdoang($_POST['jenis_over']);


    if ($jenis_over == 'over_stok') {

       $query =$db->prepare("UPDATE barang SET over_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_over, $id);


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


    $id = angkadoang($_POST['id']);
    $select_gudang = stringdoang($_POST['select_gudang']);
    $jenis_select = stringdoang($_POST['jenis_select']);


    if ($jenis_select == 'gudang') {

       $query =$db->prepare("UPDATE barang SET gudang = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_gudang, $id);


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