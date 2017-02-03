<?php session_start();
include 'db.php'; 
include 'sanitasi.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$user_buat = $_SESSION['user_name'];
      




   $query = $db->query("SELECT * FROM pembayaran_piutang WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang' ");
    while ($data = mysqli_fetch_array($query))
    {
       

        $total_bayar = $data['total'];
        $cara_bayar = $data['dari_kas'];

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data[nama_suplier]'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    $select_setting_akun = $db->query("SELECT * FROM setting_akun");
    $ambil_setting = mysqli_fetch_array($select_setting_akun);

$tbs_piutang = $db->query("SELECT potongan FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$data[no_faktur_pembayaran]'");
$data_tbs_pot = mysqli_fetch_array($tbs_piutang);
$potongan = $data_tbs_pot['potongan'];


$piutang = $total_bayar + $potongan;


 //KAS
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total_bayar', '0', 'Pembayaran Piutang', '$data[no_faktur_pembayaran]','1', '$user_buat')");


 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '0', '$piutang', 'Pembayaran Piutang', '$data[no_faktur_pembayaran]','1', '$user_buat')");


if ($potongan != "" || $potongan != '0') {
     //POTONGAN PIUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_piutang]', '$potongan', '0', 'Pembayaran Piutang', '$data[no_faktur_pembayaran]','1', '$user_buat')");
}

}

 ?>