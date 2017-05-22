<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';
//mengirimkan $id menggunakan metode GET
$session_id = session_id();
$no_reg = stringdoang($_POST['no_reg']);

//INSERT SELURUH PRODUK RADIOLOGI (KONTRAS) KE TBS RADIOLOGI

$query_pemeriksaan_radiologi = $db->query("SELECT kode_pemeriksaan, kontras FROM pemeriksaan_radiologi WHERE kontras = '0'");
    while ($data_pemeriksaan_radiologi = mysqli_fetch_array($query_pemeriksaan_radiologi))
      {
			$query_tbs_radiologi = $db->query("DELETE FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_pemeriksaan_radiologi[kode_pemeriksaan]' AND no_reg = '$no_reg' AND kontras = '0' AND status_pilih = 'Pilih Semua' ");

			$query_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE kode_jasa = '$data_pemeriksaan_radiologi[kode_pemeriksaan]' AND no_reg = '$no_reg' AND kontras = '0' AND status_pilih_radiologi = 'Pilih Semua' ");

	  }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
