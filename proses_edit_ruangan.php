<?php
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST

        $id = angkadoang($_POST['id']);
        $nama_ruangan = stringdoang($_POST['nama_ruangan']);

    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE ruangan SET nama_ruangan = ? WHERE id = ?");
    
    $query->bind_param("si",
       $nama_ruangan,$id);


    $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
// tutup statements
$query->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>