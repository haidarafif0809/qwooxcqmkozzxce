<?php 
include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_GET['kode_barang']);
$no_faktur = stringdoang($_GET['no_faktur']);

$query_detail_stok_opname = $db->query("SELECT id,no_faktur,
tanggal,
jam,
kode_barang,
nama_barang,
awal,
masuk,
keluar,
stok_sekarang,
fisik,
selisih_fisik,
selisih_harga,
harga,
hpp FROM detail_stok_opname WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");

$data = mysqli_fetch_array($query_detail_stok_opname);


$db->query("DELETE FROM detail_stok_opname WHERE id = '$data[id]'");

$sql  = "INSERT INTO detail_stok_opname (no_faktur,tanggal,jam,kode_barang,nama_barang,awal,masuk,keluar,stok_sekarang,fisik,selisih_fisik,selisih_harga,harga,hpp)	VALUES( '$data[no_faktur]','$data[tanggal]','$data[jam]','$data[kode_barang]','$data[nama_barang]',$data[awal],$data[masuk],$data[keluar],$data[stok_sekarang],$data[fisik],$data[selisih_fisik],$data[selisih_harga],$data[harga],$data[hpp])  ";


if ($db->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}



 ?>