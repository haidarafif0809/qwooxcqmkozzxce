<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}


    $nama_ruangan = stringdoang($_POST['nama_ruangan']);

$insert_ruangan = $db->prepare("INSERT INTO ruangan (nama_ruangan) VALUES (?)");
  
// hubungkan "data" dengan prepared statements
$insert_ruangan->bind_param("s",$nama_ruangan);
       
  

    $insert_ruangan->execute();
 
// cek query
if (!$insert_ruangan) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
/*else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang">';
}*/
 
// tutup statements
$insert_ruangan->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

