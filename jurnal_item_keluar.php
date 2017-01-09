<?php session_start();
include 'db.php'; 
include 'sanitasi.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$user = $_SESSION['user_name'];

    $query = $db->query("SELECT * FROM item_keluar WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang' ");
    while ($data = mysqli_fetch_array($query))
    {
       
        

$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$data[no_faktur]'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total = $ambil_sum['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$data[no_faktur]','1', '$user')");

  //ITEM KELUAR    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Keluar', '$data[no_faktur]','1', '$user')");


}



 ?>