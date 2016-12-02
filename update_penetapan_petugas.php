<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $nama_dokter = stringdoang($_POST['select_dokter']);
    $nama_paramedik = stringdoang($_POST['select_paramedik']);
    $nama_farmasi = stringdoang($_POST['select_farmasi']);
    $jenis_select = stringdoang($_POST['jenis_select']);

// UPDATE NAMA DOKTER
if ($jenis_select == 'nama_dokter') {

       $query =$db->prepare("UPDATE penetapan_petugas SET nama_dokter = ?  WHERE id = ?");

       $query->bind_param("si",
        $nama_dokter, $id);


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


// UPDATE NAMA PARAMEDIK
if ($jenis_select == 'nama_paramedik') {

       $query =$db->prepare("UPDATE penetapan_petugas SET nama_paramedik = ?  WHERE id = ?");

       $query->bind_param("si",
        $nama_paramedik, $id);


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

// UPDATE NAMA FARMASI
if ($jenis_select == 'nama_farmasi') {

       $query =$db->prepare("UPDATE penetapan_petugas SET nama_farmasi = ?  WHERE id = ?");

       $query->bind_param("si",
        $nama_farmasi, $id);


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