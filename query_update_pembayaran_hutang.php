<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_pembayaran_hutang = $db->query("SELECT no_faktur_pembayaran FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_pembayaran_hutang = mysqli_fetch_array($query_pembayaran_hutang);

$query_jurnal_trans = $db->query("SELECT no_faktur FROM jurnal_trans WHERE no_faktur = '$data_pembayaran_hutang[no_faktur_pembayaran]'");
$jumlah_data_query_jurnal_trans  = mysqli_num_rows($query_jurnal_trans);



if ($jumlah_data_query_jurnal_trans < 2)
{


$delete_jurnal_lama = $db->query(" DELETE FROM jurnal_trans WHERE jenis_transaksi = 'Pembayaran Hutang' ");


$query_pembayaranhutang = $db->query("SELECT * FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
while($data_pembayaranhutang = mysqli_fetch_array($query_pembayaranhutang)){



$select_setting_akun = $db->query("SELECT hutang,potongan_hutang FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$data_pembayaranhutang[nama_suplier]' ");
$ambil_suplier = mysqli_fetch_array($select_suplier);

$tbs_hutang = $db->query("SELECT potongan FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$data_pembayaranhutang[no_faktur_pembayaran]'");
$data_tbs_pot = mysqli_fetch_array($tbs_hutang);

$potongan = $data_tbs_pot['potongan'];
$hutang = $data_pembayaranhutang['total'] + $potongan;

        //HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$data_pembayaranhutang[tanggal] $data_pembayaranhutang[jam]', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '$hutang', '0', 'Pembayaran Hutang', '$data_pembayaranhutang[no_faktur_pembayaran]','1', '$data_pembayaranhutang[user_buat]')");

        //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$data_pembayaranhutang[tanggal] $data_pembayaranhutang[jam]', 'Pembayaran Hutang - $ambil_suplier[nama]', '$data_pembayaranhutang[dari_kas]', '0', '$data_pembayaranhutang[total]', 'Pembayaran Hutang', '$data_pembayaranhutang[no_faktur_pembayaran]','1', '$data_pembayaranhutang[user_buat]')");

if ($potongan != "" || $potongan != '0') {
     //POTONGAN HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$data_pembayaranhutang[tanggal] $data_pembayaranhutang[jam]', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[potongan_hutang]', '0', '$potongan', 'Pembayaran Hutang', '$data_pembayaranhutang[no_faktur_pembayaran]','1', '$data_pembayaranhutang[user_buat]')");
}


}//end while 
echo "success";


}//end if jika jumlah baris jurnal  kurang dari 2

 ?>