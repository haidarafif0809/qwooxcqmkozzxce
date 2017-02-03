<?php session_start();
include 'db.php'; 
include 'sanitasi.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$user_buat = $_SESSION['user_name'];




   $query = $db->query("SELECT * FROM retur_penjualan WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang' ");
    while ($data = mysqli_fetch_array($query))
    {
       

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax,SUM(subtotal) AS subtotal FROM detail_retur_penjualan WHERE no_faktur_retur = '$data[no_faktur_retur]'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);

$total_tax = $jumlah_tax['total_tax'];
$subtotal = $jumlah_tax['subtotal'];


    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data[kode_pelanggan]'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE no_faktur = '$data[no_faktur_retur]'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$ppn_input = $data['ppn'];
   
   $persediaan = $total_hpp;
   $total_akhir = $data['total'];
$cara_bayar = $data['cara_bayar'];



  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");



//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '0', '$total_hpp', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");


 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '0', '$total_akhir', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");



if ($ppn_input == "Non") {  

 

  $total_penjualan = $subtotal;  



 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");

} 

else if ($ppn_input == "Include") {
//ppn == Include


  $total_penjualan = $subtotal - $total_tax;
  $pajak = $total_tax;

if ($pajak != "" || $pajak != 0 ) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");
      }

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");



}

else {

//ppn == Exclude
  $total_penjualan = $subtotal;
  $pajak = $data['tax'];
    
if ($pajak != "" || $pajak != 0 ) {

//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");
      }
      

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");


}


if ($data['potongan'] != "" || $data['potongan'] != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_retur_jual]', '0', '$data[potongan]', 'Retur Penjualan', '$data[no_faktur_retur]','1', '$user_buat')");
}

}
 ?>