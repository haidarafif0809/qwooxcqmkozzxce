<?php

include 'db.php';

$kode_klinik_reg = $db->query("SELECT kode_klinik FROM kode_klinik_reg LIMIT 1 ")->fetch_array();
$query_pelanggan = $db_pasien->query("SELECT kode_pelanggan FROM pelanggan WHERE (kode_pelanggan != '0' OR kode_pelanggan IS NULL OR kode_pelanggan != '') AND kode_klinik = '" . $kode_klinik_reg["kode_klinik"] . "' ORDER BY id DESC LIMIT 1 ")->fetch_array();

$angka_no_rm = str_replace($kode_klinik_reg['kode_klinik'] . '-', "", $query_pelanggan['kode_pelanggan']);
$no_rm       = $angka_no_rm + 1;
echo $no_rm  = $kode_klinik_reg['kode_klinik'] . '-' . $no_rm;
