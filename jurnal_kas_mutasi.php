<?php session_start();
include 'db.php'; 
include 'sanitasi.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$waktu = date('Y-m-d H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$user_buat = $_SESSION['user_name'];




    $data_tbs = $db->query("SELECT * FROM kas_mutasi WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang' ");
    while ($data = mysqli_fetch_array($data_tbs))

{

                $pilih = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.dari_akun FROM daftar_akun da INNER JOIN kas_mutasi dk ON dk.dari_akun = da.kode_daftar_akun");
            $dari_akun_select = mysqli_fetch_array($pilih);

            $select = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.ke_akun FROM daftar_akun da INNER JOIN kas_mutasi dk ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON jt.kode_akun_jurnal = da.kode_daftar_akun WHERE jt.kode_akun_jurnal = '$data[ke_akun]'");
            $ke_akun_select = mysqli_fetch_array($select);



      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi ke $ke_akun_select[nama_daftar_akun]','$data[ke_akun]', '$data[jumlah]', '0', 'Kas Mutasi', '$data[no_faktur]','1', '$user_buat')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi dari $dari_akun_select[nama_daftar_akun]','$data[dari_akun]', '0', '$data[jumlah]', 'Kas Mutasi', '$data[no_faktur]','1', '$user_buat')");

}



 ?>
