<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

    
    $nama_barang = stringdoang($_POST['nama_barang']);
    $harga_jual = angkadoang($_POST['harga_jual']);
    $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
    $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
    $harga_jual_4 = angkadoang($_POST['harga_jual_4']);
    $harga_jual_5 = angkadoang($_POST['harga_jual_5']);
    $harga_jual_6 = angkadoang($_POST['harga_jual_6']);
    $harga_jual_7 = angkadoang($_POST['harga_jual_7']);
    $satuan = stringdoang($_POST['satuan']);
    $status = stringdoang($_POST['status']);
    $tipe = stringdoang($_POST['tipe']);
    $suplier = stringdoang($_POST['suplier']);
    $golongan_produk = stringdoang($_POST['golongan_produk']);
        

 if($tipe == 'Obat Obatan'){
  
        $golongan_obat = stringdoang($_POST['golongan_obat']);
        $kategori_obat = stringdoang($_POST['kategori_obat']);
        $jenis_obat = stringdoang($_POST['jenis_obat']);
        $harga_beli = angkadoang($_POST['harga_beli']);
        $limit_stok = angkadoang($_POST['limit_stok']);
        $over_stok = angkadoang($_POST['over_stok']);
        }

else if($tipe != 'Obat Obatan' AND $tipe != 'Jasa')
 {

        $golongan_obat = "-";
        $kategori_obat = "-";
        $jenis_obat = "-";
        $harga_beli = angkadoang($_POST['harga_beli']);
        $limit_stok = angkadoang($_POST['limit_stok']);
        $over_stok = angkadoang($_POST['over_stok']);
 }
 else 
 {
  
        $golongan_obat = "-";
        $kategori_obat = "-";
        $jenis_obat = "-";
        $harga_beli = "0";
        $limit_stok = "-";
        $over_stok = "-";
 }

    


$q_kode_barang = $db->query("SELECT kode_barang FROM barang WHERE berkaitan_dgn_stok = '$golongan_produk' ORDER BY id DESC LIMIT 1");
$v_kode_barang = mysqli_fetch_array($q_kode_barang);
$kode_barang_terakhir = $v_kode_barang['kode_barang'];
$angka_barang_terakhir = angkadoang($kode_barang_terakhir);
$kode_produk_sekarang = 1 + $angka_barang_terakhir;

if ($golongan_produk == 'Jasa') {

 $kode_produk = "J".$kode_produk_sekarang."";

}
else{

 $kode_produk = "B".$kode_produk_sekarang."";
}

 
// buat prepared statements
$stmt = "INSERT INTO barang (kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3,harga_jual4,harga_jual5,harga_jual6,harga_jual7, satuan, kategori, status, suplier, limit_stok, over_stok, berkaitan_dgn_stok,golongan,tipe_barang,jenis_barang)VALUES ('$kode_produk', '$nama_barang', '$harga_beli', '$harga_jual', '$harga_jual_2', '$harga_jual_3','$harga_jual_4','$harga_jual_5','$harga_jual_6','$harga_jual_7', '$satuan', '$kategori_obat', '$status', '$suplier', '$limit_stok', '$over_stok', '$golongan_produk','$golongan_obat','$tipe','$jenis_obat')";

if ($db->query($stmt) === TRUE) {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang_jasa">';

        } 

        else {
        echo "Error: " . $stmt . "<br>" . $db->error;
        }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

<!---->