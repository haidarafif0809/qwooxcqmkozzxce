<?php  session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
$kode = stringdoang($_POST['kode_barang']);
$nama = stringdoang($_POST['nama_barang']);
$jumlah = angkadoang($_POST['jumlah_barang']);
$harga = angkadoang($_POST['harga']);
$subtotal = $harga * $jumlah;
$tipe_barang = stringdoang($_POST['tipe_barang']);
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$no_reg  = stringdoang($_POST['no_reg']);
$kontras = angkadoang($_POST['kontras']);
$dokter_pengirim = stringdoang($_POST['dokter']);
$dokter_periksa = stringdoang($_POST['dokter_pemeriksa']);
$petugas_radiologi = stringdoang($_POST['petugas_radiologi']);


$insert_tbs = "INSERT INTO tbs_penjualan_radiologi (session_id, kode_barang, nama_barang, jumlah_barang, harga, subtotal, tipe_barang, tanggal, jam, no_reg, kontras, dokter_pengirim, dokter_periksa, dokter_pelaksana, radiologi, status_pilih) VALUES ('$session_id', '$kode', '$nama', '$jumlah', '$harga', '$subtotal', '$tipe_barang', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$kontras', '$dokter_pengirim', '$dokter_periksa', '$petugas_radiologi', 'Radiologi', 'Pilih Satu')";

    if ($db->query($insert_tbs) === TRUE){                        
    } 
    else{
      echo "Error: " . $insert_tbs . "<br>" . $db->error;
    }

?>