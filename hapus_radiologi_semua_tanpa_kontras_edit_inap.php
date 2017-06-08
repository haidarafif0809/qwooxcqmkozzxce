<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['no_reg']);
$no_pemeriksaan = stringdoang($_POST['no_pemeriksaan']);
//INSERT SELURUH PRODUK RADIOLOGI (KONTRAS) KE TBS RADIOLOGI

$query_pemeriksaan_radiologi = $db->query("SELECT kode_pemeriksaan, kontras FROM pemeriksaan_radiologi WHERE kontras = '0'");
    while ($data_pemeriksaan_radiologi = mysqli_fetch_array($query_pemeriksaan_radiologi))
      {
			$query = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_pemeriksaan_radiologi[kode_pemeriksaan]' AND no_reg = '$no_reg' AND kontras = '0' AND status_pilih = 'Pilih Semua' AND no_pemeriksaan = '$no_pemeriksaan' ");
	  }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
