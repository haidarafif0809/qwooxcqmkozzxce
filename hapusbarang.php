<?php 
// memasukan file db.php
include 'db.php';

// mengirim data $id dengan menggunakan metode GET
$id = $_POST['id'];

// menghapus seluruh data yang ada pada tabel barang berdasrkan id
$query = $db->query("DELETE FROM barang WHERE id = '$id'");

// logika => jika $query benar maka akan menuju file barang.php , jika salah maka failed
if ($query == TRUE)
{
echo "sukses";
}
else
{
	
}

$kode = $_POST['kode'];
// update chache setelah hapus barang
include 'sanitasi.php';
include 'cache.class.php';
   // setup 'default' cache
    $c = new Cache();

     // store a string

    // generate a new cache file with the name 'newcache'
 
    $c->setCache('produk');

    $c->erase($kode);




// ending update chache setelah hapus barang

mysqli_close($db);   
?>
